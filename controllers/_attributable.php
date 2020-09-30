<?
    class _attributable
    {   
        public $model;
        private $view;
        
        function __construct()
        {
            $this->model = new _attributableModel();
            $this->view = new _attributableView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('_attributableTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('_attributableForm');
        }
        
        function action()
        {
            $this->model->attributable_id = req('attributable_id');
            $this->model->attributable_name = req('attributable_name');
                            
            if(req('_attributable_id'))
            {
                $this->model->update();
                sess('alert','_attributable Updated');
                redirect(URL.'/_attributable/form/'.req('_attributable_id'));
            }else{
                $this->model->create();
                sess('alert','_attributable Created');
                redirect(URL.'/_attributable/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','_attributable Deleted');
            redirect(URL.'/_attributable');
        }
    }
?>
