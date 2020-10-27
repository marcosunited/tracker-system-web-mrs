<?
function getLifts($lifts)
{
    $string = "";
    $lifts = rtrim($lifts, "|");
    $lifts = ltrim($lifts, "|");
    $lifts = explode("|", $lifts);


    $i = 1;
    foreach ($lifts as $lift) {
        $result = db::query("select * from lifts where lift_id = $lift");
        $string .= $result[0]['lift_name'];
        if ($i < sizeof($lifts))
            $string .= ", ";
        $i++;
    }
    return $string;
}

function query($query)
{
    $result = mysqli_query(db::$conn, $query);
    return $result;
}

function get_query($query)
{
    $rows = array();

    $result = mysqli_query(db::$conn, $query);

    if (is_object($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
    }

    return $rows;
}

function sendNotification($calloutId, $model, $jobs, $_faults, $_technician_faults, $_corrections, $_attributable)
{
    //GET NEXT EMAIL ATTEMPT
    $emailHistoryModel = new emailHistoryModel();
    $maxEmailAttempt = $emailHistoryModel->getMaxAttempts();
    $nextEmailAttempt = $emailHistoryModel->getNextAttempt($calloutId);

    //STATUS 2 = CLOSED
    if ($model->notify_email != "" && $model->callout_status_id == 2 && ($nextEmailAttempt <= $maxEmailAttempt)) {
        $address = $jobs->model->job_address_number . " " . $jobs->model->job_address;
        $subject = "United Lifts Call Report";
        $description = str_replace("\r\n", "<br>", $model->callout_description);
        $fault = $_faults->model->fault_name;
        $technician_fault = $_technician_faults->model->technician_fault_name;
        $correction_name = $_corrections->model->correction_name;
        $attributable_name = $_attributable->model->attributable_name;
        $tech_description = str_replace("\r\n", "<br>", $model->tech_description);
        $toc = date("d-m-Y G:i:s", $model->callout_time);
        $toa = date("d-m-Y G:i:s", $model->time_of_arrival);
        $tod = date("d-m-Y G:i:s", $model->time_of_departure);
        $order_number = $model->order_number;
        $lift_names = getLifts($model->lift_ids);
        $login_user = sess('user_id');
        $users = mysqli_fetch_array(query("select * from technicians where technician_id = $login_user"));
        //$user_email = "reception@unitedlifts.com.au";
        $user_email = "marcos.blandon@unitedlifts.com.au";
        if ($order_number == "") {
            $order_number = "N/A";
        }

        $myID = $model->docket_number;
        $filename = (string)$model->callout_time;

        $message = "
                    <img src='http://cloud.unitedlifts.com.au/melbourne-tracker/app/images/logo.png'>
                    <p>This notification is to advise completion of your call out (Docket Number: $myID, Order Number: $order_number) to Unit('s)<br>&nbsp;<br>
                    <b>$lift_names</b> at <b>$address</b> on <b>$toc</b>.</p>
                    <p>The fault as reported to us was '<b>$fault</b>' - '<b>$description</b>'. Our technician attended at <b>$toa</b>.</p>
                    <p>The cause of the fault was '<b>$technician_fault</b>', and the technicians rectification was <b>'$correction_name'</b> - '<b>$tech_description</b>'.</p>
                    Our technician departed at <b>$tod</b>.</p>
                    <p>This callout is classified as <b>$attributable_name</b> .
                    <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                    <p>Thankyou for your continued patronage.</p>
                    <p>United Lift Services</p>               
                ";
        $emails = explode(";", $model->notify_email);

        foreach ($emails as $email) {
            $mailResponse = "FAILED";
            try {
                $emailHistoryModel->user_id = sess('user_id');
                $emailHistoryModel->item_id = $calloutId;
                $emailHistoryModel->item_type_id = 1; // 1 for collouts
                $emailHistoryModel->date_created = $model->callout_time;
                $emailHistoryModel->date_sent = time();
                $emailHistoryModel->subject = $subject;
                $emailHistoryModel->email_to = $email;
                $emailHistoryModel->email_from = 'call@unitedlifts.com.au';
                $emailHistoryModel->attempt = $nextEmailAttempt;
                $emailHistoryModel->include_attachment = 1;

                $mailResponse = mailer($email, $user_email, "call@unitedlifts.com.au", "unitedlifts.com.au", $subject, $message, $filename);

                $emailHistoryModel->status = $mailResponse == 'OK' ? 'SENT' : 'FAILED';
                $emailHistoryModel->exception_message = $mailResponse == 'OK' ? '' : $mailResponse;
            } catch (Exception $e) {
                $emailHistoryModel->status = $mailResponse;
                $emailHistoryModel->exception_message = $e->getCode() . " : " . $e->getMessage();
            } finally {
                $emailHistoryModel->create();
            }

        }

        sendPrinting($filename, $address);
    }
}

?>
