<?                
    class usersModel
    {
        public $user_id; 
        public $username; 
        public $password; 
        public $realname; 
        public $auth_level; 
        public $image; 
        public $user_email; 
        public $list;

        function create()
        {
            return db::query("INSERT INTO users (username,password,realname,auth_level,image,user_email) VALUES ('$this->username','$this->password','$this->realname',0$this->auth_level,'$this->image','$this->user_email');");
        }
        
        function read($id)
        {
            $user = db::query("select * from users where user_id = $id");     
                       
            if($user){
                $user = $user[0]; 
                $this->user_id = $user['user_id'];
                $this->username = $user['username'];
                $this->password = $user['password'];
                $this->realname = $user['realname'];
                $this->auth_level = $user['auth_level'];
                $this->image = $user['image'];
                $this->user_email = $user['user_email'];
                return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE users SET
                      username = '$this->username',        
                      password = '$this->password',        
                      realname = '$this->realname',        
                      auth_level = 0$this->auth_level,        
                      image = '$this->image',        
                      user_email = '$this->user_email'        
                      WHERE user_id = $this->user_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from users where user_id = $id");
            return db::query("delete from users where user_id = $this->user_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from users');
        }
        
        function checkLogin($user,$password)
        {
            return db::query("select * from users where username = '$user' AND password='$password'");
        }            
    }
?>