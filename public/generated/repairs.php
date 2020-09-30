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
            $this->view->render('repairsForm');
        }
        
        function action()
        {
            $this->model->repair_id = req('repair_id');
            $this->model->job_id = req('job_id');
            $this->model->technician_id = req('technician_id');
            $this->model->repair_status_id = req('repair_status_id');
            $this->model->lift_ids = req('lift_ids');
            $this->model->repair_description = req('repair_description');
            $this->model->tech_details = req('tech_details');
            $this->model->parts_required = req('parts_required');
            $this->model->time_of_arrival = req('time_of_arrival');
            $this->model->time_of_departure = req('time_of_departure');
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
