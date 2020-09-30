<?
    class menu
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new menuModel();
            $this->view = new menuView($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('menuTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('menuForm');
        }
        
        function action()
        {
            $this->model->menu_id = req('menu_id');
            $this->model->menu_name = req('menu_name');
            $this->model->class_name = req('class_name');
            $this->model->auth_level = req('auth_level');
            $this->model->menu_order = req('menu_order');
            $this->model->menu_parent = req('menu_parent');
            $this->model->menu_target = req('menu_target');
            $this->model->level_only = req('level_only');
                            
            if(req('menu_id'))
            {
                $this->model->update();
                sess('alert','Menu Updated');
                redirect(URL.'/menu/form/'.req('menu_id'));
            }else{
                $this->model->create();
                sess('alert','Menu Created');
                redirect(URL.'/menu/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','Menu Deleted');
            redirect(URL.'/menu');
        }
    }
?>
