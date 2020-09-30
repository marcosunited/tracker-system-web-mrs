<h1>Users</h1>
<p><a href="<?=URL?>/users" class="button-primary">Back to users</a></p>

<form role="form" action="<?=URL?>/users/action/" method="post">
    <input type="hidden" name="user_id" value="<?=$this->model->user_id?>">

                
        <label>Id: </label><input type="text" name="user_id" placeholder="user_id" class="form-control" value="<?=$this->model->user_id?>"><br>
                    
        <label>Username: </label><input type="text" name="username" placeholder="username" class="form-control" value="<?=$this->model->username?>"><br>
                    
        <label>Password: </label><input type="text" name="password" placeholder="password" class="form-control" value="<?=$this->model->password?>"><br>
                    
        <label>Realname: </label><input type="text" name="realname" placeholder="realname" class="form-control" value="<?=$this->model->realname?>"><br>
                    
        <label>Auth level: </label><input type="text" name="auth_level" placeholder="auth_level" class="form-control" value="<?=$this->model->auth_level?>"><br>
                    
        <label>Image: </label><input type="text" name="image" placeholder="image" class="form-control" value="<?=$this->model->image?>"><br>
                    
        <label>Email: </label><input type="text" name="user_email" placeholder="user_email" class="form-control" value="<?=$this->model->user_email?>"><br>
            <input type="submit" class="button-primary" value="Save">
</form>

