<?                
    class _technician_faultsModel
    {
        public $technician_fault_id; 
        public $technician_fault_name; 
        public $technician_fault_full_name; 
        public $tech_hidden; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _technician_faults (technician_fault_name,technician_fault_full_name,tech_hidden) VALUES ('$this->technician_fault_name','$this->technician_fault_full_name',0$this->tech_hidden);");
        }
        
        function read($id)
        {
            $_technician_fault = db::query("select * from _technician_faults where technician_fault_id = $id");     
                       
            if($_technician_fault){
                $_technician_fault = $_technician_fault[0]; 
                $this->technician_fault_id = $_technician_fault['technician_fault_id'];
                $this->technician_fault_name = $_technician_fault['technician_fault_name'];
                $this->technician_fault_full_name = $_technician_fault['technician_fault_full_name'];
                $this->tech_hidden = $_technician_fault['tech_hidden'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _technician_faults SET
                      technician_fault_name = '$this->technician_fault_name',        
                      technician_fault_full_name = '$this->technician_fault_full_name',        
                      tech_hidden = 0$this->tech_hidden        
                      WHERE _technician_fault_id = $this->_technician_fault_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _technician_faults where _technician_fault_id = $id");
            return db::query("delete from _technician_faults where _technician_fault_id = $this->_technician_fault_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _technician_faults');
        }        
    }
?>