<?    
    class maintenanceView extends view
    {
        public $model;
        public $modelWeek;

        function __construct(maintenanceModel $model ,maintenanceWeekModel $maintenanceWeekModel)
        {
            $this->model = $model;
            $this->modelWeek = $maintenanceWeekModel;
        }

    }
?>
