<?                
    class _correctionsModel
    {
        public $correction_id; 
        public $correction_name; 
        public $type; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO _corrections (correction_name,type) VALUES ('$this->correction_name','$this->type');");
        }
        
        function read($id)
        {
            $_correction = db::query("select * from _corrections where correction_id = $id");     
                       
            if($_correction){
                $_correction = $_correction[0]; 
                $this->correction_id = $_correction['correction_id'];
                $this->correction_name = $_correction['correction_name'];
                $this->type = $_correction['type'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE _corrections SET
                      correction_name = '$this->correction_name',        
                      type = '$this->type'        
                      WHERE correction_id = $this->correction_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from _corrections where correction_id = $id");
            return db::query("delete from _corrections where correction_id = $this->correction_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from _corrections');
        }        
    }
?>