<?
    class _faults
    {   
        public $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _faultsModel();
            $this->view = new _faultsView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_faultsTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_faultsForm');
        }
        
        function action()
        {
            $this->model->fault_id = req('fault_id');
            $this->model->fault_name = req('fault_name');
            $this->model->fault_full_name = req('fault_full_name');
                            
            if(req('_fault_id'))
            {
                $this->model->update();
                sess('alert','_fault Updated');
                redirect(URL.'/_faults/form/'.req('_fault_id'));
            }else{
                $this->model->create();
                sess('alert','_fault Created');
                redirect(URL.'/_faults/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_fault Deleted');
            redirect(URL.'/_faults');
        }
    }
?>
