<?                
    class calloutsModel
    {
        public $callout_id; 
        public $is_printed; 
        public $job_id; 
        public $fault_id; 
        public $technician_id; 
        public $technician_fault_id; 
        public $priority_id; 
        public $callout_status_id; 
        public $lift_ids; 
        public $floor_no; 
        public $callout_description; 
        public $correction_id;
        public $attributable_id;
        public $tech_description; 
        public $order_number; 
        public $docket_number; 
        public $contact_details; 
        public $callout_time; 
        public $time_of_arrival; 
        public $time_of_departure; 
        public $chargeable_id; 
        public $technician_signature; 
        public $customer_signature; 
        public $accepted_id; 
        public $updated; 
        public $user_id; 
        public $notify_email; 
        public $list;
        public $rectification_time;
        public $reported_customer;
        public $part_description;
		public $photo_name;
        
        function create()
        {
                           
            $query1 = "INSERT INTO callouts 
            (is_printed,job_id,fault_id,technician_id,technician_fault_id,priority_id,callout_status_id,lift_ids,
            floor_no,callout_description,part_description,correction_id,attributable_id,tech_description,order_number,
            docket_number,contact_details,callout_time,time_of_arrival,rectification_time,time_of_departure,chargeable_id,
            technician_signature,customer_signature,accepted_id,updated,user_id,notify_email,reported_customer,photo_name) VALUES 
            (0$this->is_printed,0$this->job_id,0$this->fault_id,0$this->technician_id,0$this->technician_fault_id,
            0$this->priority_id,0$this->callout_status_id,'$this->lift_ids','$this->floor_no','$this->callout_description',
            '$this->part_description',0$this->correction_id,0$this->attributable_id,'$this->tech_description',
            '$this->order_number','$this->docket_number','$this->contact_details',0$this->callout_time,0$this->time_of_arrival,
            0$this->rectification_time,0$this->time_of_departure,0$this->chargeable_id,'$this->technician_signature',
            '$this->customer_signature',0$this->accepted_id,0$this->updated,0$this->user_id,'$this->notify_email',
            '$this->reported_customer','$this->photo_name')";

            return db::query($query1);
        }
        
        function read($id)
        {
            $callout = db::query("select * from callouts 
            inner join jobs on callouts.job_id = jobs.job_id
            where callout_id = $id");     
                       
            if($callout){
                $callout = $callout[0]; 
                $this->callout_id = $callout['callout_id'];
                $this->is_printed = $callout['is_printed'];
                $this->job_id = $callout['job_id'];
                $this->fault_id = $callout['fault_id'];
                $this->technician_id = $callout['technician_id'];
                $this->technician_fault_id = $callout['technician_fault_id'];
                $this->priority_id = $callout['priority_id'];
                $this->callout_status_id = $callout['callout_status_id'];
                $this->lift_ids = $callout['lift_ids'];
                $this->floor_no = $callout['floor_no'];
                $this->callout_description = $callout['callout_description'];
				$this->part_description = $callout['part_description'];
                $this->correction_id = $callout['correction_id'];
                $this->attributable_id = $callout['attributable_id'];
                $this->tech_description = $callout['tech_description'];
                $this->order_number = $callout['order_number'];
                $this->docket_number = $callout['docket_number'];
                $this->contact_details = $callout['contact_details'];
                $this->callout_time = $callout['callout_time'];
                $this->time_of_arrival = $callout['time_of_arrival'];
                $this->time_of_departure = $callout['time_of_departure'];
                $this->chargeable_id = $callout['chargeable_id'];
                $this->technician_signature = $callout['technician_signature'];
                $this->customer_signature = $callout['customer_signature'];
                $this->accepted_id = $callout['accepted_id'];
                $this->updated = $callout['updated'];
                $this->user_id = $callout['user_id'];
                $this->notify_email = $callout['notify_email'];
                $this->rectification_time = $callout['rectification_time'];
                $this->reported_customer = $callout['reported_customer'];
				$this->photo_name = $callout['photo_name'];
                
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE callouts SET
                      is_printed = 0$this->is_printed,        
                      job_id = 0$this->job_id,        
                      fault_id = 0$this->fault_id,        
                      technician_id = 0$this->technician_id,        
                      technician_fault_id = 0$this->technician_fault_id,        
                      priority_id = 0$this->priority_id,        
                      callout_status_id = 0$this->callout_status_id,        
                      lift_ids = '$this->lift_ids',        
                      floor_no = '$this->floor_no',        
                      callout_description = '$this->callout_description',        
                      correction_id = 0$this->correction_id,  
                      attributable_id = 0$this->attributable_id,
                      tech_description = '$this->tech_description', 
                      part_description = '$this->part_description',       
                      order_number = '$this->order_number',        
                      docket_number = '$this->docket_number',        
                      contact_details = '$this->contact_details',        
                      callout_time = 0$this->callout_time,        
                      time_of_arrival = 0$this->time_of_arrival,        
                      time_of_departure = 0$this->time_of_departure,        
                      chargeable_id = 0$this->chargeable_id,        
                      technician_signature = '$this->technician_signature',        
                      customer_signature = '$this->customer_signature',        
                      accepted_id = 0$this->accepted_id,        
                      updated = 0$this->updated,        
                      user_id = 0$this->user_id,        
                      notify_email = '$this->notify_email',    
                      rectification_time = 0$this->rectification_time,  
                      reported_customer = '$this->reported_customer',
					  photo_name = '$this->photo_name'
                      WHERE callout_id = $this->callout_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from callouts where callout_id = $id");
            return db::query("delete from callouts where callout_id = $this->callout_id");
        }

        function readAll($where)
        {
            $this->list = db::query("
                select 
                    callout_id,
                    callout_time,
                    docket_number,
                    time_of_arrival,
                    time_of_departure,
                    callouts.job_id,
                    job_number,
                    job_name,
                    job_group,
                    job_address_number,
                    job_address,
                    job_suburb,
                    rounds.round_name,
                    rounds.round_id,
                    fault_name,
                    callouts.fault_id,
                    technician_fault_name,
                    floor_no,
                    order_number,
                    callout_description,
                    lift_ids,
                    technician_name,
                    callouts.technician_fault_id,
                    tech_description,
                    technicians.technician_id,
                    priority_name,
                    callout_status_name,
                    callouts.callout_status_id,
                    callouts.accepted_id,    
                    _accepted.accepted_name,
                    _chargeable.chargeable_name,
                    _chargeable.chargeable_id,
                    is_printed,
                    part_description,
                    rectification_time,
                    reported_customer,
					photo_name

                    from callouts

                    inner join  jobs on callouts.job_id = jobs.job_id
                    inner join _faults on callouts.fault_id = _faults.fault_id
                    inner join _technician_faults on callouts.technician_fault_id = _technician_faults.technician_fault_id
                    inner join technicians on callouts.technician_id = technicians.technician_id
                    inner join _priorities on callouts.priority_id = _priorities.priority_id
                    inner join _callout_status on callouts.callout_status_id = _callout_status.callout_status_id
                    inner join _chargeable on callouts.chargeable_id = _chargeable.chargeable_id
                    inner join _accepted on callouts.accepted_id = _accepted.accepted_id
                    inner join rounds on jobs.round_id = rounds.round_id
                    inner join _corrections on callouts.correction_id = _corrections.correction_id
                    inner join _attributable on callouts.attributable_id = _attributable.attributable_id

                    $where
            ");
        }        
    }
?>