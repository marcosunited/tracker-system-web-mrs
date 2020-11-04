<?php
function sendMaintenanceNotification($model, $jobs, $lifts, $filename)
{
    if($model->notify_email != ""){
        $address = $jobs->model->job_address_number . " " . $jobs->model->job_address;
        $subject = "United Lifts Maintenance Report";
        $toc = date("d-m-Y G:i:s",$model->maintenance_date);
        $toa = date("d-m-Y G:i:s",$model->maintenance_toa);
        $tod = date("d-m-Y G:i:s",$model->maintenance_tod);
        $order_number = $model->order_no;
        $lift_names = "";

        $i=1;
        foreach($lifts as $lift){
            $lift_names .= $lift['lift_name'] ;
            if($i < sizeof($lifts)) $lift_names .= ", ";
            $i++;
        }

        $user_email = "reception@unitedlifts.com.au";
        if($order_number == ""){
            $order_number = "N/A";
        }

        $myID = $model->docket_no;

        $message = "
                        <img src='http://cloud.unitedlifts.com.au/melbourne-tracker/app/images/logo.png'>
                        <p>This notification is to advise completion of your Maintenance (Docket Number: $myID, Order Number: $order_number) to Unit('s)<br>&nbsp;<br>
                         at <b>$address</b> on <b>$toc</b>.</p>
                        
                        Our technician departed at <b>$tod</b>.</p> .
                        <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                        <p>Thankyou for your continued patronage.</p>
                        <p>United Lift Services</p>               
                    ";
        $emails = explode(";",$model->notify_email);

        foreach($emails as $email){
            mailer($email,$user_email,"call@unitedlifts.com.au","unitedlifts.com.au",$subject,$message,$filename );
        }

        sendPrinting($filename, $address);
    }

}
