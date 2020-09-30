<?    
    class calloutsView extends view
    {
        public $model;

        function __construct(calloutsModel $model)
        {
          $this->model = $model;
        }
    }
?>
