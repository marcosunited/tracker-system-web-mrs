<?                
    class _faultsModel
    {
        public $fault_id; 
        public $fault_name; 
        public $fault_full_name; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _faults (fault_name,fault_full_name) VALUES ('$this->fault_name','$this->fault_full_name');");
        }
        
        function read($id)
        {
            $_fault = db::query("select * from _faults where fault_id = $id");     
                       
            if($_fault){
                $_fault = $_fault[0]; 
                $this->fault_id = $_fault['fault_id'];
                $this->fault_name = $_fault['fault_name'];
                $this->fault_full_name = $_fault['fault_full_name'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _faults SET
                      fault_name = '$this->fault_name',        
                      fault_full_name = '$this->fault_full_name'        
                      WHERE _fault_id = $this->_fault_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _faults where _fault_id = $id");
            return db::query("delete from _faults where _fault_id = $this->_fault_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _faults');
        }        
    }
?>