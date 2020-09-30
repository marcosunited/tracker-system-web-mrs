<?
    class gps_tracker
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new gps_trackerModel();
            $this->view = new gps_trackerView($this->model);        
        }

        function index()
        {
            $this->model->log_time = time();
            $this->model->user_id = req('user_id');
            $this->model->latitude = req('lat');
            $this->model->longitude = req('long');
                            
            $this->model->create();     
        }

    }
?>
