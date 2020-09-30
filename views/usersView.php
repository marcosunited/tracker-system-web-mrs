<?    
    class usersView extends view
    {
        public $model1;
        public $model2;
        public $currentUser;

        function __construct(usersModel $model1,jobsModel $model2,$currentUser)
        {
          $this->model1 = $model1;
          $this->model2 = $model2;
          $this->currentUser = $currentUser;
        }
    }
?>
