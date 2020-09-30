<?
    class login
    {
        private $model1;
        private $model2;
        private $view;
        private $currentUser;
        
        function __construct()
        {
            $this->model1 = new usersModel();
            $this->model2 = new jobsModel();
            $this->currentUser = "";
            $this->view = new usersView($this->model1,$this->model2,$this->currentUser);                
        }
        
        function index()
        {
            $currentUser = sess('user_id');
            $this->model2->readAll("where status_id = 1");
            if(sess('user_id')==0){
                $this->view->render('loginForm');
            }else{
                $this->view->render('home');   
            }
        }
        
        function action()
        {
            $result = $this->model1->checkLogin(req('user_name'),md5(req('user_password')));

            if($result){
                sess('user_id',$result[0]['user_id']);
                sess('user_name',$result[0]['username']);
                sess('user_level',$result[0]['auth_level']);
                sess('alert','Login Successful.<br>Welcome back '.ucfirst(sess('user_name')).' :)');
                redirect(URL."/home/");
                
            }else{
                sess('alert','Login Failed');
                redirect(URL);
            }
        }
        
        function logout()
        {
            session_unset();
            redirect(URL);
        }
    }
?>