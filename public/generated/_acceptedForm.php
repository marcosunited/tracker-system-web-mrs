<h1>_accepted</h1>
<p><a href="<?=URL?>/_accepted" class="button-primary">Back to _accepted</a></p>

<form role="form" action="<?=URL?>/_accepted/action/" method="post">
    <input type="hidden" name="_accepted_id" value="<?=$this->model->_accepted_id?>">

                
        <label>Accepted id: </label><input type="text" name="accepted_id" placeholder="accepted_id" class="form-control" value="<?=$this->model->accepted_id?>"><br>
                    
        <label>Accepted name: </label><input type="text" name="accepted_name" placeholder="accepted_name" class="form-control" value="<?=$this->model->accepted_name?>"><br>
            <input type="submit" class="button-primary" value="Save">
</form>

