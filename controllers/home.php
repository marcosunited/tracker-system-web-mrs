<?
    class home
    {
        private $model1;
        private $model2;
        private $view;
        
        function __construct()
        {
            $this->model1 = new usersModel();
            $this->model2 = new jobsModel();
            $this->view = new usersView($this->model1,$this->model2);                
        }
        function index()
        {
            $this->model2->readAll();
            $view->render('home');
        }
    }
?>