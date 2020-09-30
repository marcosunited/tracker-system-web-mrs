<?                
    class maintenanceModel
    {
        public $maintenance_id; 
        public $maintenance_date; 
        public $technician_id; 
        public $job_id; 
        public $lift_ids; 
        public $service_area_ids; 
        public $service_type_ids; 
        public $task_ids; 
        public $maintenance_notes; 
        public $completed_id; 
        public $maintenance_toa; 
        public $maintenance_tod; 
        public $docket_no; 
        public $order_no; 
        public $customer_signature; 
        public $technician_signature; 
        public $updated; 
        public $user_id; 
        public $is_printed; 
        public $notify_email;
        public $list;

        public $yearmonth ; // 201901
        public $lift_id; 
        public $customer_name;

        function create()
        {
            $customerSignature = substr( $this->customer_signature ,0 ,500 );
            $technician_signature = "";
            $sql = "INSERT INTO maintenance (maintenance_date,technician_id,job_id,lift_ids,service_area_ids,service_type_ids,task_ids,maintenance_notes,completed_id,maintenance_toa,maintenance_tod,docket_no,order_no,customer_signature,technician_signature,updated,user_id,is_printed,notify_email ,yearmonth ,lift_id ,customer_name) VALUES (0$this->maintenance_date,0$this->technician_id,0$this->job_id,'$this->lift_ids','$this->service_area_ids','$this->service_type_ids','$this->task_ids','$this->maintenance_notes',0$this->completed_id,0$this->maintenance_toa,0$this->maintenance_tod,'$this->docket_no','$this->order_no','$customerSignature', '$technician_signature' ,0$this->updated,0$this->user_id, $this->is_printed,'$this->notify_email' ,$this->yearmonth,$this->lift_id ,'$this->customer_name'  );" ;

            return db::executeQuery($sql);
        }
        function isMaintenanceDoneBefore( $liftid , $yearmonth )
        {
            $maintenance = db::query("select * from maintenance where lift_id = $liftid AND yearmonth = $yearmonth");  

            if($maintenance){
                return true;
            }

            return false;
        }
        function getTechnicianNameOfMaintenance($liftid , $yearmonth ,$session_userid)
        {
            
            $alertMsg = 'There is already a maintenance for this month (' .$yearmonth. ' ) in the system ,you can not create a new maintenance record for this month ,so please update existing record.';
                    
            

            $maintenance = db::query("select t.*   
                                      from maintenance m
                                        JOIN technicians t ON m.technician_id = t.technician_id 
                                      where lift_id = $liftid AND yearmonth = $yearmonth");  

            
            if($maintenance){

                $technician_name =$maintenance[0]['technician_name'];
                $technician_id =$maintenance[0]['technician_id'];

                if($technician_id != $session_userid)
                    $alertMsg = $alertMsg .'You should log on the system by ('. $technician_name . ') account to update the existing maintenance record' ; 

            }

            return $alertMsg;
        }
        function read($id)
        {
            $maintenance = db::query("select * from maintenance inner join jobs on maintenance.job_id = jobs.job_id 
            where maintenance_id = $id");     
                       
            if($maintenance){
                $maintenance = $maintenance[0]; 
                $this->maintenance_id = $maintenance['maintenance_id'];
                $this->maintenance_date = $maintenance['maintenance_date'];
                $this->technician_id = $maintenance['technician_id'];
                $this->job_id = $maintenance['job_id'];
                $this->lift_ids = $maintenance['lift_ids'];
                $this->service_area_ids = $maintenance['service_area_ids'];
                $this->service_type_ids = $maintenance['service_type_ids'];
                $this->task_ids = $maintenance['task_ids'];
                $this->maintenance_notes = $maintenance['maintenance_notes'];
                $this->completed_id = $maintenance['completed_id'];
                $this->maintenance_toa = $maintenance['maintenance_toa'];
                $this->maintenance_tod = $maintenance['maintenance_tod'];
                $this->docket_no = $maintenance['docket_no'];
                $this->order_no = $maintenance['order_no'];
                $this->customer_signature = $maintenance['customer_signature'];
                $this->technician_signature = $maintenance['technician_signature'];
                $this->updated = $maintenance['updated'];
                $this->user_id = $maintenance['user_id'];
                $this->is_printed = $maintenance['is_printed'];
                $this->notify_email = $maintenance['notify_email'];

                $this->yearmonth = $maintenance['yearmonth'] ;
                $this->lift_id = $maintenance['lift_id'] ;
                $this->customer_name = $maintenance['customer_name'] ;
               
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE maintenance SET
                      maintenance_date = 0$this->maintenance_date, technician_id = 0$this->technician_id,        
                      job_id = 0$this->job_id,        
                      lift_ids = '$this->lift_ids',        
                      service_area_ids = '$this->service_area_ids', service_type_ids = '$this->service_type_ids',        
                      task_ids = '$this->task_ids',        
                      maintenance_notes = '$this->maintenance_notes',        
                      completed_id = 0$this->completed_id,        
                      maintenance_toa = 0$this->maintenance_toa, maintenance_tod = 0$this->maintenance_tod,        
                      docket_no = '$this->docket_no',order_no = '$this->order_no',        
                      updated = 0$this->updated,user_id = 0$this->user_id , is_printed = 0$this->is_printed,
                      yearmonth = $this->yearmonth, customer_name = '$this->customer_name' ,
                      notify_email = '$this->notify_email'                   
                      WHERE maintenance_id = $this->maintenance_id
            ";
            return db::executeQuery($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from maintenance where maintenance_id = $id");
            return db::query("delete from maintenance where maintenance_id = $this->maintenance_id");
        }

        function readAll($where)
        {
            $this->list = db::query("select * from maintenance
                    inner join jobs on maintenance.job_id = jobs.job_id
                    inner join technicians on maintenance.technician_id = technicians.technician_id
                    left  join lifts on  maintenance.lift_id = lifts.lift_id
                    $where
                    ");
        }        
    }
?>