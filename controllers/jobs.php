<?
    class jobs
    {   
        public $model;
        public $modelMaintenance;
        
        private $view;
        
        function __construct()
        {
            $this->model = new jobsModel();
            $this->modelMaintenance = new maintenanceModel();

            $this->view = new jobsView($this->model ,$this->modelMaintenance ); 
            
        }
        
        function index()
        {          
            			
			if(req("search")){
				$this->model->readAll("where job_name like '%".req("search")."%' OR job_address like '%".req("search")."%'");
			}else{
				$this->model->readAll("where status_id = 1");	
			}
			
			$this->view->render('jobsTable');
		
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $currentYear = date("Y");
            $job_id = req('id');
            $login_user = sess('user_id'); 
            //we removed completed_id = 2 ,we show all maintenances now for whole year           
            $this->modelMaintenance->readAll("where maintenance.job_id = $job_id AND maintenance.technician_id = $login_user  AND maintenance.yearmonth like '$currentYear%' order by maintenance.lift_id ,maintenance.yearmonth   DESC Limit 40");            
            
            $this->view->render('jobsForm');
        }
        
        function action()
        {
            $this->model->job_id = req('job_id');
            $this->model->agent_id = req('agent_id');
            $this->model->frequency_id = req('frequency_id');
            $this->model->status_id = req('status_id');
            $this->model->job_number = req('job_number');
            $this->model->job_name = req('job_name');
            $this->model->job_floors = req('job_floors');
            $this->model->job_address = req('job_address');
            $this->model->job_address_number = req('job_address_number');
            $this->model->job_suburb = req('job_suburb');
            $this->model->job_contact_details = req('job_contact_details');
            $this->model->job_email = req('job_email');
            $this->model->job_owner_details = req('job_owner_details');
            $this->model->job_group = req('job_group');
            $this->model->round_id = req('round_id');
            $this->model->job_longitude = req('job_longitude');
            $this->model->job_latitude = req('job_latitude');
            $this->model->job_agent_contact = req('job_agent_contact');
            $this->model->job_key_access = req('job_key_access');
            $this->model->notify_instant = req('notify_instant');
                            
            if(req('job_id'))
            {
                $this->model->update();
                sess('alert','Job Updated');
                redirect(URL.'/jobs/form/'.req('job_id'));
            }else{
                $this->model->create();
                sess('alert','Job Created');
                redirect(URL.'/jobs/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','Job Deleted');
            redirect(URL.'/jobs');
        }
        
        function lifts()
        {
            return checkList('lifts','lift_id','lift_name','current value','where job_id = '.req("id"));
        }
        
        function contacts()
        {
            $this->model->read(req('id'));
            echo $this->model->job_contact_details;
        }
        function emails(){
            $this->model->read(req('id'));
            print_r($this->model->job_email);            
        }
    }
?>
