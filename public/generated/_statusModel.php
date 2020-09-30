<?                
    class _statusModel
    {
        public $status_id; 
        public $status_name; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _status (status_name) VALUES ('$this->status_name');");
        }
        
        function read($id)
        {
            $_statu = db::query("select * from _status where _statu_id = $id");     
                       
            if($_statu){
                $_statu = $_statu[0]; 
                $this->status_id = $_statu['status_id'];
                $this->status_name = $_statu['status_name'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _status SET
                      status_name = '$this->status_name'        
                      WHERE _statu_id = $this->_statu_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _status where _statu_id = $id");
            return db::query("delete from _status where _statu_id = $this->_statu_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _status');
        }        
    }
?>