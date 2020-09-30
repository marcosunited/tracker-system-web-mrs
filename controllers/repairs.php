<?
    class repairs
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new repairsModel();
            $this->view = new repairsView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('repairsTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
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
			
            $data = array(
                "jobs"=>$jobs,
				"user_email"=>$user_email
            );
            $this->view->render('repairsForm',$data);    
        }
        
        function action()
        {
            $this->model->repair_id = req('repair_id');
            $this->model->job_id = req('job_id');
            $this->model->technician_id = sess('user_id');
            $this->model->repair_status_id = req('repair_status_id');
            $this->model->lift_ids = getChecked('lift_id');
            $this->model->repair_description = req('repair_description');
            $this->model->tech_details = req('tech_details');
            $this->model->parts_required = req('parts_required');
            $this->model->time_of_arrival = strtotime(req('time_of_arrival'));
            $this->model->time_of_departure = strtotime(req('time_of_departure'));
            $this->model->chargeable_id = req('chargeable_id');
            $this->model->quoted_price = req('quoted_price');
            $this->model->repair_time = req('repair_time');
            $this->model->notify_email = req('notify_email');
            $this->model->parts_description = req('parts_description');
            $this->model->updated = req('updated');
            $this->model->user_id = req('user_id');
            $this->model->quote_no = req('quote_no');
            $this->model->order_no = req('order_no');
                            
            if(req('repair_id'))
            {
                $this->model->update();
                sess('alert','Repair Updated');
                redirect(URL.'/repairs/form/'.req('repair_id'));
            }else{
                $this->model->create();
                sess('alert','Repair Created');
                redirect(URL.'/repairs/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','Repair Deleted');
            redirect(URL.'/repairs');
        }
    }
?>
