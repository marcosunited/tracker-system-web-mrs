<?    
    class _statusView extends view
    {
        public $model;

        function __construct(_statusModel $model)
        {
          $this->model = $model;
        }
    }
?>
