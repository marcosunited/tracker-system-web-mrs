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
                    redirect(URL.'/maintenance/form/?job_id='.req('job_id'));                               
                }
            }


            if ($printOk) //we email and print simlutaneosly 
            {
                sendMaintenanceNotification($this->model, $jobs, $lifts, $fileName);
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
