<?    
    class _attributableView extends view
    {
        public $model;

        function __construct(_attributableModel $model)
        {
          $this->model = $model;
        }
    }
?>
