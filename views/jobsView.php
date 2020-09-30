<?    
    class jobsView extends view
    {
        public $model;
        public $modelMaintenance;

        function __construct(jobsModel $model ,$modelMaintenance =null)
        {
          $this->model = $model;
          if( $modelMaintenance != null ) $this->modelMaintenance = $modelMaintenance;
        }
    }
?>
