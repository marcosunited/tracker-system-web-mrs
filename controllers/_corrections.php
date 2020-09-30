<?
    class _corrections
    {   
        public $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _correctionsModel();
            $this->view = new _correctionsView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_correctionsTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_correctionsForm');
        }
        
        function action()
        {
            $this->model->correction_id = req('correction_id');
            $this->model->correction_name = req('correction_name');
            $this->model->type = req('type');
                            
            if(req('_correction_id'))
            {
                $this->model->update();
                sess('alert','_correction Updated');
                redirect(URL.'/_corrections/form/'.req('_correction_id'));
            }else{
                $this->model->create();
                sess('alert','_correction Created');
                redirect(URL.'/_corrections/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_correction Deleted');
            redirect(URL.'/_corrections');
        }
    }
?>
