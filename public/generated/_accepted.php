<?
    class _accepted
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _acceptedModel();
            $this->view = new _acceptedView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_acceptedTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_acceptedForm');
        }
        
        function action()
        {
            $this->model->accepted_id = req('accepted_id');
            $this->model->accepted_name = req('accepted_name');
                            
            if(req('_accepted_id'))
            {
                $this->model->update();
                sess('alert','_accepted Updated');
                redirect(URL.'/_accepted/form/'.req('_accepted_id'));
            }else{
                $this->model->create();
                sess('alert','_accepted Created');
                redirect(URL.'/_accepted/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_accepted Deleted');
            redirect(URL.'/_accepted');
        }
    }
?>
