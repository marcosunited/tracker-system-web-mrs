<h1>Menu</h1>
<p><a href="<?=URL?>/menu" class="button-primary">Back to menu</a></p>

<form role="form" action="<?=URL?>/menu/action/" method="post">
    <input type="hidden" name="menu_id" value="<?=$this->model->menu_id?>">

                
        <input type="hidden" name="menu_id" placeholder="menu_id" class="form-control" value="<?=$this->model->menu_id?>">
                    
        <label>Name: </label><input type="text" name="menu_name" placeholder="menu_name" class="form-control" value="<?=$this->model->menu_name?>"><br>
                    
        <label>Class name: </label><input type="text" name="class_name" placeholder="class_name" class="form-control" value="<?=$this->model->class_name?>"><br>
                    
        <label>Auth level: </label><input type="text" name="auth_level" placeholder="auth_level" class="form-control" value="<?=$this->model->auth_level?>"><br>
                    
        <label>Order: </label><input type="text" name="menu_order" placeholder="menu_order" class="form-control" value="<?=$this->model->menu_order?>"><br>
                    
        <label>Parent: </label><input type="text" name="menu_parent" placeholder="menu_parent" class="form-control" value="<?=$this->model->menu_parent?>"><br>
                    
        <label>Target: </label><input type="text" name="menu_target" placeholder="menu_target" class="form-control" value="<?=$this->model->menu_target?>"><br>
                    
        <label>Level only: </label><input type="text" name="level_only" placeholder="level_only" class="form-control" value="<?=$this->model->level_only?>"><br>
            <input type="submit" class="button-primary" value="Save">
</form>

