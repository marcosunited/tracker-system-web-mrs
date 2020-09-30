<?    
    class _chargeableView extends view
    {
        public $model;

        function __construct(_chargeableModel $model)
        {
          $this->model = $model;
        }
    }
?>
