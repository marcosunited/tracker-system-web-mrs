<h1>Repairs</h1>
<p><a href="<?=URL?>/repairs" class="button-primary">Back to repairs</a></p>

<form role="form" action="<?=URL?>/repairs/action/" method="post">
    <input type="hidden" name="repair_id" value="<?=$this->model->repair_id?>">

                
        <label>Id: </label><input type="text" name="repair_id" placeholder="repair_id" class="form-control" value="<?=$this->model->repair_id?>"><br>
                    
        <label>Job id: </label><input type="text" name="job_id" placeholder="job_id" class="form-control" value="<?=$this->model->job_id?>"><br>
                    
        <label>Technician id: </label><input type="text" name="technician_id" placeholder="technician_id" class="form-control" value="<?=$this->model->technician_id?>"><br>
                    
        <label>Status id: </label><input type="text" name="repair_status_id" placeholder="repair_status_id" class="form-control" value="<?=$this->model->repair_status_id?>"><br>
                    
        <label>Lift ids: </label><input type="text" name="lift_ids" placeholder="lift_ids" class="form-control" value="<?=$this->model->lift_ids?>"><br>
                    
        <label>Description: </label><input type="text" name="repair_description" placeholder="repair_description" class="form-control" value="<?=$this->model->repair_description?>"><br>
                    
        <label>Tech details: </label><input type="text" name="tech_details" placeholder="tech_details" class="form-control" value="<?=$this->model->tech_details?>"><br>
                    
        <label>Parts required: </label><input type="text" name="parts_required" placeholder="parts_required" class="form-control" value="<?=$this->model->parts_required?>"><br>
                    
        <label>Time of arrival: </label><input type="text" name="time_of_arrival" placeholder="time_of_arrival" class="form-control" value="<?=$this->model->time_of_arrival?>"><br>
                    
        <label>Time of departure: </label><input type="text" name="time_of_departure" placeholder="time_of_departure" class="form-control" value="<?=$this->model->time_of_departure?>"><br>
                    
        <label>Chargeable id: </label><input type="text" name="chargeable_id" placeholder="chargeable_id" class="form-control" value="<?=$this->model->chargeable_id?>"><br>
                    
        <label>Quoted price: </label><input type="text" name="quoted_price" placeholder="quoted_price" class="form-control" value="<?=$this->model->quoted_price?>"><br>
                    
        <label>Time: </label><input type="text" name="repair_time" placeholder="repair_time" class="form-control" value="<?=$this->model->repair_time?>"><br>
                    
        <label>Notify email: </label><input type="text" name="notify_email" placeholder="notify_email" class="form-control" value="<?=$this->model->notify_email?>"><br>
                    
        <label>Parts description: </label><input type="text" name="parts_description" placeholder="parts_description" class="form-control" value="<?=$this->model->parts_description?>"><br>
                    
        <label>Updated: </label><input type="text" name="updated" placeholder="updated" class="form-control" value="<?=$this->model->updated?>"><br>
                    
        <label>User id: </label><input type="text" name="user_id" placeholder="user_id" class="form-control" value="<?=$this->model->user_id?>"><br>
                    
        <label>Quote no: </label><input type="text" name="quote_no" placeholder="quote_no" class="form-control" value="<?=$this->model->quote_no?>"><br>
                    
        <label>Order no: </label><input type="text" name="order_no" placeholder="order_no" class="form-control" value="<?=$this->model->order_no?>"><br>
            <input type="submit" class="button-primary" value="Save">
</form>

