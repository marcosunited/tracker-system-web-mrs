<?    
    class gps_trackerView extends view
    {
        public $model;

        function __construct(gps_trackerModel $model)
        {
          $this->model = $model;
        }
    }
?>
