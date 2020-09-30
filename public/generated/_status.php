<?
    class _status
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _statusModel();
            $this->view = new _statusView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_statusTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_statusForm');
        }
        
        function action()
        {
            $this->model->status_id = req('status_id');
            $this->model->status_name = req('status_name');
                            
            if(req('_statu_id'))
            {
                $this->model->update();
                sess('alert','_statu Updated');
                redirect(URL.'/_status/form/'.req('_statu_id'));
            }else{
                $this->model->create();
                sess('alert','_statu Created');
                redirect(URL.'/_status/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_statu Deleted');
            redirect(URL.'/_status');
        }
    }
?>
