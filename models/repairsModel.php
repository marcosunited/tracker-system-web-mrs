<?                
    class repairsModel
    {
        public $repair_id; 
        public $job_id; 
        public $technician_id; 
        public $repair_status_id; 
        public $lift_ids; 
        public $repair_description; 
        public $tech_details; 
        public $parts_required; 
        public $time_of_arrival; 
        public $time_of_departure; 
        public $chargeable_id; 
        public $quoted_price; 
        public $repair_time; 
        public $notify_email; 
        public $parts_description; 
        public $updated; 
        public $user_id; 
        public $quote_no; 
        public $order_no; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO repairs (job_id,technician_id,repair_status_id,lift_ids,repair_description,tech_details,parts_required,time_of_arrival,time_of_departure,chargeable_id,quoted_price,repair_time,notify_email,parts_description,updated,user_id,quote_no,order_no) VALUES (0$this->job_id,0$this->technician_id,0$this->repair_status_id,'$this->lift_ids','$this->repair_description','$this->tech_details','$this->parts_required',0$this->time_of_arrival,0$this->time_of_departure,0$this->chargeable_id,0$this->quoted_price,0$this->repair_time,'$this->notify_email','$this->parts_description',0$this->updated,0$this->user_id,0$this->quote_no,0$this->order_no);");
        }
        
        function read($id)
        {
            $repair = db::query("select * from repairs 
            inner join jobs on repairs.job_id = jobs.job_id
            where repair_id = $id");     
                       
            if($repair){
                $repair = $repair[0]; 
                $this->repair_id = $repair['repair_id'];
                $this->job_id = $repair['job_id'];
                $this->technician_id = $repair['technician_id'];
                $this->repair_status_id = $repair['repair_status_id'];
                $this->lift_ids = $repair['lift_ids'];
                $this->repair_description = $repair['repair_description'];
                $this->tech_details = $repair['tech_details'];
                $this->parts_required = $repair['parts_required'];
                $this->time_of_arrival = $repair['time_of_arrival'];
                $this->time_of_departure = $repair['time_of_departure'];
                $this->chargeable_id = $repair['chargeable_id'];
                $this->quoted_price = $repair['quoted_price'];
                $this->repair_time = $repair['repair_time'];
                $this->notify_email = $repair['notify_email'];
                $this->parts_description = $repair['parts_description'];
                $this->updated = $repair['updated'];
                $this->user_id = $repair['user_id'];
                $this->quote_no = $repair['quote_no'];
                $this->order_no = $repair['order_no'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE repairs SET
                      job_id = 0$this->job_id,        
                      technician_id = 0$this->technician_id,        
                      repair_status_id = 0$this->repair_status_id,        
                      lift_ids = '$this->lift_ids',        
                      repair_description = '$this->repair_description',        
                      tech_details = '$this->tech_details',        
                      parts_required = '$this->parts_required',        
                      time_of_arrival = 0$this->time_of_arrival,        
                      time_of_departure = 0$this->time_of_departure,        
                      chargeable_id = 0$this->chargeable_id,        
                      quoted_price = 0$this->quoted_price,        
                      repair_time = 0$this->repair_time,        
                      notify_email = '$this->notify_email',        
                      parts_description = '$this->parts_description',        
                      updated = 0$this->updated,        
                      user_id = 0$this->user_id,        
                      quote_no = 0$this->quote_no,        
                      order_no = 0$this->order_no        
                      WHERE repair_id = $this->repair_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from repairs where repair_id = $id");
            return db::query("delete from repairs where repair_id = $this->repair_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from repairs
            inner join  jobs on repairs.job_id = jobs.job_id
            inner join technicians on repairs.technician_id = technicians.technician_id                   
            inner join _repair_status on repairs.repair_status_id = _repair_status.repair_status_id
            inner join _chargeable on repairs.chargeable_id = _chargeable.chargeable_id
            inner join rounds on jobs.round_id = rounds.round_id
            ');
        }        
    }
?>