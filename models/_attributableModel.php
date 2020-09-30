<?                
    class _attributableModel
    {
        public $attributable_id; 
        public $attributable_name; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _attributable (attributable_name) VALUES ('$this->attributable_name');");
        }
        
        function read($id)
        {
            $_attributable = db::query("select * from _attributable where attributable_id = $id");     
                       
            if($_attributable){
                $_attributable = $_attributable[0]; 
                $this->attributable_id = $_attributable['attributable_id'];
                $this->attributable_name = $_attributable['attributable_name'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _attributable SET
                      attributable_name = '$this->attributable_name'        
                      WHERE attributable_id = $this->attributable_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _attributable where _attributable_id = $id");
            return db::query("delete from _attributable where _attributable_id = $this->_attributable_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _attributable');
        }        
    }
?>