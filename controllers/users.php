<?
    class users
    {   
        private $model;
        private $model2;
        private $view;
        
        function __construct()
        {
            $this->model = new usersModel();
            $this->model2 = new jobsModel();
            $this->view = new usersView($this->model,$this->model2);                
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('usersTable');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('usersForm');
        }
        
        function action()
        {
            $this->model->user_id = req('user_id');
            $this->model->username = req('username');
            $this->model->password = req('password');
            $this->model->realname = req('realname');
            $this->model->auth_level = req('auth_level');
            $this->model->image = req('image');
            $this->model->user_email = req('user_email');
                            
            if(req('user_id'))
            {
                $this->model->update();
                sess('alert','User Updated');
                redirect(URL.'/users/form/'.req('user_id'));
            }else{
                $this->model->create();
                sess('alert','User Created');
                redirect(URL.'/users/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','User Deleted');
            redirect(URL.'/users');
        }
    }
?>
