<?
    class maintenance
    {   
        private $model;
        private $modelMaintenanceWeek;
        private $view;
        
        function __construct()
        {
            $this->model = new maintenanceModel();
            $this->modelMaintenanceWeek = new maintenanceWeekModel();  
            $this->view = new maintenanceView($this->model ,$this->modelMaintenanceWeek);        
        }
        
        function index()
        {   
            //we are showing not signed maintenances
            $login_user = sess('user_id');       
            //$this->model->readAll("where completed_id = 2 AND maintenance.technician_id = $login_user order by maintenance_date DESC Limit 40");
            $this->model->readAll("where maintenance.technician_id = $login_user order by yearmonth DESC ,maintenance_date DESC  Limit 100");                                    
            $this->view->render('maintenanceTable');
        }
        
        function form()
        {
            $updateMode = false; //if there is a maintenance id ,form is opened by update mode

            //$this->model->read(req('id'));
            $updateMode = $this->model->read(req('id'));
           
            $jobs = new jobs();
            
            if(req('job_id')){
                $jobs->model->read(req('job_id'));
				$this->model->notify_email = $jobs->model->job_email; 
            }else{
                 $jobs->model->read($this->model->job_id);  
            }
			
			$login_user = sess('user_id');
			$users = mysqli_fetch_array(query("select * from technicians where technician_id = $login_user"));
			$user_email = $users['technician_email'];
            
            $disabled = ""; //for this moment we dont disable form elements,otherwise we cant reach their values
            //if($this->model->completed_id == 2)
            if($updateMode) 
                $disabled = ""; //"DISABLED";
            
            $data = array (
                "jobs"=>$jobs,
                "disabled"=>$disabled,
				"user_email"=>$user_email
            );
            
            $this->view->render('maintenanceForm',$data);
        }
        
        function action()
        {
            $this->model->maintenance_id = req('maintenance_id');
            $this->modelMaintenanceWeek->maintenance_id = req('maintenance_id');

            $this->model->maintenance_date = strtotime(req('maintenance_date'));
            $this->model->technician_id = req('technician_id');
            $this->model->job_id = req('job_id');
            $this->model->lift_ids = getChecked('lift_id');
            $this->model->service_area_ids = getChecked('service_area_id');
            $this->model->service_type_ids = getChecked('service_type_id');
            $this->model->task_ids = getChecked('task_id');
            $this->modelMaintenanceWeek->task_ids = getChecked('task_id');
            
            $this->model->maintenance_notes = req('maintenance_notes');
            //$this->model->completed_id = req('completed_id');
            $this->model->maintenance_toa = strtotime(req('maintenance_toa'));
            $this->modelMaintenanceWeek->toa_date = strtotime(req('maintenance_toa'));
            $this->model->maintenance_tod = strtotime(req('maintenance_tod'));
            $this->modelMaintenanceWeek->tod_date = strtotime(req('maintenance_tod'));
            
            $this->model->docket_no = req('docket_no');            
            //$this->modelMaintenanceWeek->docketno = req('docket_no');
            
            //error_log("kod");
            //error_log(req('docket_no'));            
            
            $this->model->order_no = req('order_no');
            $this->model->customer_signature = req('customer_signature');
            $this->model->technician_signature = req('technician_signature');
            $this->model->updated = time();
            $this->model->user_id = sess('user_id');
            $this->model->notify_email = req('notify_email');
            $this->model->is_printed = req('sign_and_print');
            $this->model->customer_name = req('customer_name');
            
            $printOk =false ;
            if( $this->model->is_printed > 0 )  $printOk = true;

            if( req('yearmonth') == null) // form in create mode
            {
                $year = date("Y");
                $active_month = trim( substr( req('active_month') ,5 ,2 ));
                if( strlen($active_month) == 1 ) $active_month = "0" . $active_month;

                $this->model->yearmonth = $year . $active_month;                
            }
            else    // form in update  mode
                $this->model->yearmonth =  req('yearmonth');

            $active_week = req('active_week');
            $this->modelMaintenanceWeek->yearmonthweek = $this->model->yearmonth . $active_week ;    

            $jobs = new jobs();
            $jobs->model->read(req('job_id'));

            $job_id = $this->model->job_id;
            $lifts = get_query("select * from lifts where job_id = $job_id");

            $user_id = $this->model->technician_id;
            $user =  mysqli_fetch_array(query("select * from users where user_id = $user_id"));
                            
            //we will use only 1 lift number
            $liftsIdsChecked =  explode("|" , $this->model->lift_ids); 
            
            foreach($liftsIdsChecked as $liftId) {
               if( $liftId == "" ) continue;
               $this->model->lift_id = $liftId;            
               break;
           }

           //this will give us checked list ids ,we are setting 
           $liftTasksChecked = explode("|" , $this->model->task_ids);
           $fileName = strtotime("now");
           //$filename = (string)$this->model->maintenance_date;

            if(req('maintenance_id')  &&  !$printOk )
            {                
                $result = $this->model->update();        
                if($result != true)        
                {
                    sess('alert','Maintenance record could not be updated!'. $result);                    
                    redirect( $_SERVER['HTTP_REFERER']) ;                   
                    return;
                }

                if($this->modelMaintenanceWeek->isWeeklyMaintenanceExist())
                {
                    $result = $this->modelMaintenanceWeek->updateByMaintenance();
                }
                else
                {
                    $result = $this->modelMaintenanceWeek->create(); 
                }
                //No more print for update
                /*
                $data = array(
                "jobs"=>$jobs,
                "user"=>$user,
                "lifts"=>$lifts
                 );                     
                $this->view->render('maintenancePrint',$data); */

                sess('alert','Maintenance Updated');
                //redirect(URL.'/maintenance/form/'.req('maintenance_id'));
                redirect(URL.'/maintenance/'); 
            }else{
                if( $printOk )
                {                    
                    $this->model->lift_id = rand( -100000 ,0); //this is just for inserting purpose
                    
                    $docketNo = req('docket_no'); //we only care about docketNo when printed
                    if( strlen( $docketNo) == 0 )           
                    {   
                        $this->model->docket_no = rand(0 ,100000);
                    }
                        
                }
                else
                {
                    if($this->model->isMaintenanceDoneBefore( $this->model->lift_id , $this->model->yearmonth ))
                    {
                        $alertMsg = $this->model->getTechnicianNameOfMaintenance($this->model->lift_id , $this->model->yearmonth, sess('user_id'));

                        sess('alert' ,$alertMsg ) ;
                        redirect( $_SERVER['HTTP_REFERER']) ;
                        return;
                    }
                }
                $result = $this->model->create();                
                
                if($result == false)        
                {
                    sess('alert', 'Maintenance record could not be created ,please contact IT personnel');
                    redirect( $_SERVER['HTTP_REFERER'] );                     
                    return;
                } 

                $login_user = sess('user_id');
                //This is set only for print part
                $this->model->readAll("where maintenance.technician_id = $login_user  AND maintenance.job_id = $job_id AND maintenance.lift_id = " .$this->model->lift_id ." AND yearmonth = " .$this->model->yearmonth ." order by maintenance_id DESC ");                        
            
                //weekly maintenances are recorded ,IMPORTANT we should get list and its last one is needed ,because last one is recorded last
                $lastIndex = sizeof($this->model->list) - 1;
                $this->modelMaintenanceWeek->maintenance_id = $this->model->list[$lastIndex]['maintenance_id'];
                
                if( !($this->model->lift_id < 0 ) ) // no need to keep signed maintenances week history
                    $result = $this->modelMaintenanceWeek->create(); 
                
                //we need to readAll again to adjust maintenance record to print all tasks ,because we use it for printing docket within all tasks from all lifts
                $this->model->readAll("where maintenance.technician_id = $login_user  AND maintenance.job_id = $job_id " ." AND yearmonth = " .$this->model->yearmonth ." order by maintenance_id DESC ");                        
                
                if ($printOk)
                {
                    $data = array(
                    "jobs"=>$jobs,
                    "user"=>$user,
                    "lifts"=>$lifts,
                    "fileName"=>$fileName
                    );                     

                    $this->view->renderPdf('maintenancePrint',$data);
                    redirect(URL.'/maintenance/');
                }                             
                else
                {
                    sess('alert','Maintenance Created');
                    //redirect(URL.'/maintenance/');
                    redirect(URL.'/maintenance/form/?job_id='.req('job_id'));                               
                }
            }


            if ($printOk) //we email and print simlutaneosly 
            {
                if($this->model->notify_email != "" /*&& $this->model->completed_id==2 */){
                    $address = $jobs->model->job_address_number . " " . $jobs->model->job_address;
                    $subject = "United Lifts Maintenance Report";
                    // $description = str_replace("\r\n","<br>",$this->model->callout_description);
                    // $fault = $_faults->model->fault_name;
                    // $technician_fault = $_technician_faults->model->technician_fault_name;
                    // $correction_name = $_corrections->model->correction_name;
                    // $attributable_name = $_attributable->model->attributable_name;
                    //$tech_description = str_replace("\r\n","<br>",$this->model->tech_description);
                    $toc = date("d-m-Y G:i:s",$this->model->maintenance_date);
                    $toa = date("d-m-Y G:i:s",$this->model->maintenance_toa);
                    $tod = date("d-m-Y G:i:s",$this->model->maintenance_tod);
                    $order_number = $this->model->order_no;
                    $lift_names = ""; // getLifts($this->model->lift_ids);

                    $i=1;
                    foreach($lifts as $lift){
                        $lift_names .= $lift['lift_name'] ;
                        if($i<sizeof($lifts)) $lift_names .= ", ";
                        $i++;
                    }

                    $login_user = sess('user_id');
                    $users = mysqli_fetch_array(query("select * from technicians where technician_id = $login_user"));
                    $user_email = "reception@unitedlifts.com.au";
                    if($order_number == ""){
                        $order_number = "N/A";
                    }
                    
                    $myID = $this->model->docket_no;
                    //$filename = (string)$this->model->maintenance_date;

                    $message = "
                        <img src='http://cloud.unitedlifts.com.au/melbourne-tracker/app/images/logo.png'>
                        <p>This notification is to advise completion of your Maintenance (Docket Number: $myID, Order Number: $order_number) to Unit('s)<br>&nbsp;<br>
                         at <b>$address</b> on <b>$toc</b>.</p>
                        
                        Our technician departed at <b>$tod</b>.</p> .
                        <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                        <p>Thankyou for your continued patronage.</p>
                        <p>United Lift Services</p>               
                    ";
                    $emails = explode(";",$this->model->notify_email);
                    
                    foreach($emails as $email){
                        mailer($email,$user_email,"call@unitedlifts.com.au","unitedlifts.com.au",$subject,$message,$fileName );
                    }
                    
                    require_once 'public/cloudprint/Config.php';
                    require_once 'public/cloudprint/GoogleCloudPrint.php';
                        
                    // Create object
                    $gcp = new GoogleCloudPrint();

                    // Replace token you got in offlineToken.php
                    $refreshTokenConfig['refresh_token'] = '1//0eYFKLUcMw6RaCgYIARAAGA4SNwF-L9Ir0u-uESO2vQDphPbsq21Sc1TwJdIOS-JhxJUeGJwk7R1nvrS9pGXYuoQ_yrCCmJOtbnQ'; //melbourne

                    $token = $gcp->getAccessTokenByRefreshToken($urlconfig['refreshtoken_url'],http_build_query($refreshTokenConfig));

                    $gcp->setAuthToken($token);

                    $printers = $gcp->getPrinters();
                    //print_r($printers);

                    $printerid = "3e05bcb9-e61b-5ff1-0383-664ffa9b1cc5";
                    if(count($printers)==0) {                        
                        echo "Could not get printers";
                        exit;
                    }
                    else {
                        
                        //$printerid = $printers[1]['id']; // Pass id of any printer to be used for print
                        // Send document to the printer
                        $resarray = $gcp->sendPrintToPrinter($printerid, $address, "functions/pdfReports/$fileName.pdf", "application/pdf");
                        
                        if($resarray['status']==true) {                            
                            echo "Document has been sent to printer and should print shortly.";                            
                        }
                        else {
                            echo "An error occured while printing the doc. Error code:".$resarray['errorcode']." Message:".$resarray['errormessage'];
                        }
                    }
                }

            }
        }

        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','Maintenance Deleted');
            redirect(URL.'/maintenance');
        }
    }
?>
