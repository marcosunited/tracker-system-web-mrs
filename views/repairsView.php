<?    
    class repairsView extends view
    {
        public $model;

        function __construct(repairsModel $model)
        {
          $this->model = $model;
        }
    }
?>
