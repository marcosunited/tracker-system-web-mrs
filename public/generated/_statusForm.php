<h1>_status</h1>
<p><a href="<?=URL?>/_status" class="button-primary">Back to _status</a></p>

<form role="form" action="<?=URL?>/_status/action/" method="post">
    <input type="hidden" name="_statu_id" value="<?=$this->model->_statu_id?>">

                
        <label>Status id: </label><input type="text" name="status_id" placeholder="status_id" class="form-control" value="<?=$this->model->status_id?>"><br>
                    
        <label>Status name: </label><input type="text" name="status_name" placeholder="status_name" class="form-control" value="<?=$this->model->status_name?>"><br>
            <input type="submit" class="button-primary" value="Save">
</form>

