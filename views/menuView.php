<?    
    class menuView extends view
    {
        public $model;

        function __construct(menuModel $model)
        {
          $this->model = $model;
        }
    }
?>
