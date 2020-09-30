<?                
    class gps_trackerModel
    {
        public $id; 
        public $log_time; 
        public $user_id; 
        public $latitude; 
        public $longitude; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO gps_tracker (log_time,user_id,latitude,longitude) VALUES (0$this->log_time,'$this->user_id','$this->latitude','$this->longitude');");
        }     
    }
?>