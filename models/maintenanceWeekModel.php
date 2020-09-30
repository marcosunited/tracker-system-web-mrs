<?                
    class maintenanceWeekModel
    {
        public $id;         
        public $maintenance_id; 
        public $task_ids;         
        public $yearmonthweek ; // 2019011
        public $date; 
        public $toa_date;
        public $tod_date;

        function create()
        {
            //If there is already a docket number entered we dont generate another one
            /*error_log("xxxx");            
            error_log(strlen($this->docketno));
            error_log("yyy");            
            
            if( strlen($this->docketno) == 0 )           
            {    $this->docketno = rand(0 ,100000);}
            */
            $sql = "INSERT INTO maintenance_tasks_weekly(maintenance_id ,task_ids ,year_month_week ,toa_date ,tod_date ) VALUES ($this->maintenance_id, '$this->task_ids',$this->yearmonthweek , $this->toa_date ,$this->tod_date );" ;
            
            error_log("volkan"); 
            
            error_log($sql); 
            return db::executeQuery($sql);
        }
        
        
        function read($id)
        {
            $maintenanceWeekly = db::query("select * from maintenance_tasks_weekly where id = $id");     
                       
            if($maintenanceWeekly){
                $maintenanceWeek = $maintenanceWeekly[0]; 
                $this->id = $maintenanceWeek['id'];
                $this->maintenance_id = $maintenanceWeek['maintenance_id'];                
                $this->task_ids = $maintenance['task_ids'];
                $this->yearmonthweek = $maintenance['year_month_week'];                
                $this->date = $maintenance['date'];
                $this->toa_date = $maintenance['toa_date'];
                $this->tod_date = $maintenance['tod_date'];
                
                return true;
            }
           
            return false;
        }
        function isWeeklyMaintenanceExist()
        {
            $maintenanceWeekly = db::query("select * from maintenance_tasks_weekly where maintenance_id = $this->maintenance_id AND year_month_week = $this->yearmonthweek ");     
                       
            if($maintenanceWeekly){
                return true;
            }
           
            return false;
        }
        function update()
        {
            $query = "UPDATE maintenance_tasks_weekly 
                      SET task_ids = '$this->task_ids'                                      
                      WHERE id = $this->id";

            return db::executeQuery($query);
        }
        function updateByMaintenance()
        {
            $query = "UPDATE maintenance_tasks_weekly 
                      SET task_ids = '$this->task_ids'                                      
                      WHERE maintenance_id = $this->maintenance_id AND year_month_week = $this->yearmonthweek";

            return db::executeQuery($query);
        }
        function delete($id = null)
        {
            if($id)
                return db::query("delete from maintenance_tasks_weekly where  id = $id");
            return db::query("delete from maintenance_tasks_weekly where id = $this->id");
        }

            
    }
?>