<?                
    class jobsModel
    {
        public $job_id; 
        public $agent_id; 
        public $frequency_id; 
        public $status_id; 
        public $job_number; 
        public $job_name; 
        public $job_floors; 
        public $job_address; 
        public $job_address_number; 
        public $job_suburb; 
        public $job_contact_details; 
        public $job_email; 
        public $job_owner_details; 
        public $job_group; 
        public $round_id; 
        public $job_longitude; 
        public $job_latitude; 
        public $job_agent_contact; 
        public $job_key_access; 
        public $notify_instant; 
        public $list;
        public $contract_id;
        public $important_notes;
        
        //Extra names
		public $contract_name;
        public $agent_name;
        public $frequency_name;
        public $status_name;
        public $round_name;
        

        function create()
        {
            return db::query("INSERT INTO jobs (agent_id,frequency_id,status_id,job_number,job_name,job_floors,job_address,job_address_number,job_suburb,job_contact_details,job_email,job_owner_details,job_group,round_id,job_longitude,job_latitude,job_agent_contact,job_key_access,notify_instant) VALUES (0$this->agent_id,0$this->frequency_id,0$this->status_id,'$this->job_number','$this->job_name','$this->job_floors','$this->job_address','$this->job_address_number','$this->job_suburb','$this->job_contact_details','$this->job_email','$this->job_owner_details','$this->job_group',0$this->round_id,'$this->job_longitude','$this->job_latitude','$this->job_agent_contact','$this->job_key_access',0$this->notify_instant);");
        }
        
        function read($id)
        {
            $job = db::query("select * from jobs 
            inner join agents on jobs.agent_id = agents.agent_id
            inner join _frequency on jobs.frequency_id = _frequency.frequency_id
            inner join _status on jobs.status_id = _status.status_id
            inner join rounds on jobs.round_id = rounds.round_id
            inner join _contract on jobs.contract_id = _contract.contract_id
            inner join technicians on jobs.round_id = technicians.round_id
            where job_id = $id");     
                       
            if($job){
                $job = $job[0]; 
                $this->job_id = $job['job_id'];
                $this->agent_id = $job['agent_id'];
                $this->frequency_id = $job['frequency_id'];
                $this->status_id = $job['status_id'];
                $this->job_number = $job['job_number'];
                $this->job_name = $job['job_name'];
                $this->job_floors = $job['job_floors'];
                $this->job_address = $job['job_address'];
                $this->job_address_number = $job['job_address_number'];
                $this->job_suburb = $job['job_suburb'];
                $this->job_contact_details = $job['job_contact_details'];
                $this->job_email = $job['job_email'];
                $this->job_owner_details = $job['job_owner_details'];
                $this->job_group = $job['job_group'];
                $this->round_id = $job['round_id'];
                $this->job_longitude = $job['job_longitude'];
                $this->job_latitude = $job['job_latitude'];
                $this->job_agent_contact = $job['job_agent_contact'];
                $this->job_key_access = $job['job_key_access'];
                $this->notify_instant = $job['notify_instant'];
                $this->contract_id = $job['contract_id'];
                $this->important_notes = $job['important_notes'];
                
                $this->contract_name = $job['contract_name'];
				$this->agent_name = $job["agent_name"];
                $this->frequency_name = $job["frequency_name"];
                $this->status_name = $job["status_name"];
                $this->round_name = $job["round_name"]; 
                $this->technician_name = $job["technician_name"];                
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE jobs SET
                      agent_id = 0$this->agent_id,        
                      frequency_id = 0$this->frequency_id,        
                      status_id = 0$this->status_id,        
                      job_number = '$this->job_number',        
                      job_name = '$this->job_name',        
                      job_floors = '$this->job_floors',        
                      job_address = '$this->job_address',        
                      job_address_number = '$this->job_address_number',        
                      job_suburb = '$this->job_suburb',        
                      job_contact_details = '$this->job_contact_details',        
                      job_email = '$this->job_email',        
                      job_owner_details = '$this->job_owner_details',        
                      job_group = '$this->job_group',        
                      round_id = 0$this->round_id,        
                      job_longitude = '$this->job_longitude',        
                      job_latitude = '$this->job_latitude',        
                      job_agent_contact = '$this->job_agent_contact',        
                      job_key_access = '$this->job_key_access',        
                      notify_instant = 0$this->notify_instant        
                      WHERE job_id = $this->job_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from jobs where job_id = $id");
            return db::query("delete from jobs where job_id = $this->job_id");
        }

        function readAll($where = null)
        {
            $this->list = db::query("select * from jobs $where");
        }   

        function readSpecial($where = null)
        {
            $this->list = db::query("select * from jobs inner join technicians on jobs.round_id = technicians.round_id
            inner join users on users.realname = technicians.technician_name             
            $where");
        }     
    }
?>