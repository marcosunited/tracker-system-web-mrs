<?
    class _technician_faults
    {   
        public $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _technician_faultsModel();
            $this->view = new _technician_faultsView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_technician_faultsTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_technician_faultsForm');
        }
        
        function action()
        {
            $this->model->technician_fault_id = req('technician_fault_id');
            $this->model->technician_fault_name = req('technician_fault_name');
            $this->model->technician_fault_full_name = req('technician_fault_full_name');
            $this->model->tech_hidden = req('tech_hidden');
                            
            if(req('_technician_fault_id'))
            {
                $this->model->update();
                sess('alert','_technician_fault Updated');
                redirect(URL.'/_technician_faults/form/'.req('_technician_fault_id'));
            }else{
                $this->model->create();
                sess('alert','_technician_fault Created');
                redirect(URL.'/_technician_faults/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_technician_fault Deleted');
            redirect(URL.'/_technician_faults');
        }
    }
?>
