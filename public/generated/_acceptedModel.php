<?                
    class _acceptedModel
    {
        public $accepted_id; 
        public $accepted_name; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _accepted (accepted_name) VALUES ('$this->accepted_name');");
        }
        
        function read($id)
        {
            $_accepted = db::query("select * from _accepted where _accepted_id = $id");     
                       
            if($_accepted){
                $_accepted = $_accepted[0]; 
                $this->accepted_id = $_accepted['accepted_id'];
                $this->accepted_name = $_accepted['accepted_name'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _accepted SET
                      accepted_name = '$this->accepted_name'        
                      WHERE _accepted_id = $this->_accepted_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _accepted where _accepted_id = $id");
            return db::query("delete from _accepted where _accepted_id = $this->_accepted_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _accepted');
        }        
    }
?>