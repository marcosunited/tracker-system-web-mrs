<?                
    class _chargeableModel
    {
        public $chargeable_id; 
        public $chargeable_name; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _chargeable (chargeable_name) VALUES ('$this->chargeable_name');");
        }
        
        function read($id)
        {
            $_chargeable = db::query("select * from _chargeable where chargeable_id = $id");     
                       
            if($_chargeable){
                $_chargeable = $_chargeable[0]; 
                $this->chargeable_id = $_chargeable['chargeable_id'];
                $this->chargeable_name = $_chargeable['chargeable_name'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _chargeable SET
                      chargeable_name = '$this->chargeable_name'        
                      WHERE chargeable_id = $this->chargeable_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _chargeable where _chargeable_id = $id");
            return db::query("delete from _chargeable where _chargeable_id = $this->_chargeable_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _chargeable');
        }        
    }
?>