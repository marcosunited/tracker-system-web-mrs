<?                
    class menuModel
    {
        public $menu_id; 
        public $menu_name; 
        public $class_name; 
        public $auth_level; 
        public $menu_order; 
        public $menu_parent; 
        public $menu_target; 
        public $level_only; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO menu_mrs (menu_name,class_name,auth_level,menu_order,menu_parent,menu_target,level_only) VALUES ('$this->menu_name','$this->class_name',0$this->auth_level,0$this->menu_order,0$this->menu_parent,'$this->menu_target',0$this->level_only);");
        }
        
        function read($id)
        {
            $menu = db::query("select * from menu_mrs where menu_id = $id");     
                       
            if($menu){
                $menu = $menu[0]; 
                $this->menu_id = $menu['menu_id'];
                $this->menu_name = $menu['menu_name'];
                $this->class_name = $menu['class_name'];
                $this->auth_level = $menu['auth_level'];
                $this->menu_order = $menu['menu_order'];
                $this->menu_parent = $menu['menu_parent'];
                $this->menu_target = $menu['menu_target'];
                $this->level_only = $menu['level_only'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE menu_mrs SET
                      menu_name = '$this->menu_name',        
                      class_name = '$this->class_name',        
                      auth_level = 0$this->auth_level,        
                      menu_order = 0$this->menu_order,        
                      menu_parent = 0$this->menu_parent,        
                      menu_target = '$this->menu_target',        
                      level_only = 0$this->level_only        
                      WHERE menu_id = $this->menu_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from menu where menu_id = $id");
            return db::query("delete from menu where menu_id = $this->menu_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from menu_mrs');
        }        
    }
?>