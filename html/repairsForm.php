<h1>Repairs</h1>
<p><a href="<?=URL?>/repairs" class="button-primary">Back to repairs</a></p>

<form role="form" action="<?=URL?>/repairs/action/" method="post">
    <input type="hidden" name="repair_id" value="<?=$this->model->repair_id?>">
    <input type="hidden" name="user_id" placeholder="user_id"  value="<?=$this->model->user_id?>">
        <input type="hidden" name="updated" placeholder="updated"  value="<?=$this->model->updated?>">
        <input type="hidden" name="technician_id" placeholder="technician_id"  value="<?=$this->model->technician_id?>">
        <input type="hidden" name="job_id" value="<?=$jobs->model->job_id?>">

                    
        <label>Repair For:</label><h5><?=$jobs->model->job_name?> - <?=$jobs->model->job_address_number?> <?=$jobs->model->job_address?></h5>
        <label>Repair Id: </label><?=$this->model->repair_id?><br> 
        <label>Staus</label><?dropList('_repair_status','repair_status_id','repair_status_name',$this->model->repair_status_id);?><br>
        <label>Order number: </label><input autocomplete="off" required type="text" name="order_no" placeholder="order_no"  value="<?=$this->model->order_no?>"><br>            

         
        <label>For Unit(s): </label>
        <input name="liftcheck" id="liftcheck" style="width:1px;height:1px;border:0px;">
        <div id="lifts"><?checkList('lifts','lift_id','lift_name',$this->model->lift_ids,'where job_id = '.$jobs->model->job_id." order by lift_name ASC");?></div>
        <h5>Tech Details</h5>          
        <label>Repair Description: </label><input type="text" name="repair_description" placeholder="repair_description" class="form-control" value="<?=$this->model->repair_description?>"><br>
                                       
        <label>Parts required: </label><input type="text" name="parts_required" placeholder="parts_required" class="form-control" value="<?=$this->model->parts_required?>"><br>
                    
        <label>Time of arrival: </label><input id="toa" autocomplete="off"   required class="date" type="datetime-local" name="time_of_arrival" placeholder="time_of_arrival"  value="<?=toDateTime($this->model->time_of_arrival)?>"><br>                   
        <label>Time of departure: </label><input id="tod" autocomplete="off"   required class="date" type="datetime-local" name="time_of_departure" placeholder="time_of_departure"  value="<?=toDateTime($this->model->time_of_departure)?>"><br>
                    
        <label>Chargeable: </label><?dropList('_chargeable','chargeable_id','chargeable_name',$this->model->chargeable_id);?>
                    
        <label>Quote No: </label><input type="text" name="quote_no" placeholder="quote_no" class="form-control" value="<?=$this->model->quote_no?>"><br>
                    
        <label>Notify email: </label><input type="text" name="notify_email" placeholder="notify_email" class="form-control" value="<?=$jobs->model->job_email?>"><br>
                    
        <label>Parts description: </label><input type="text" name="parts_description" placeholder="parts_description" class="form-control" value="<?=$this->model->parts_description?>"><br>
        <input type="submit" class="button-primary" value="Save">
</form>

<script>
    $(document).ready(function(){

        if(!isMobile()){
			$('#callout_time').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
            $('#rot').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });

            var startDateTextBox = $('#toa');
             var endDateTextBox = $('#tod');

        $.timepicker.datetimeRange(
            startDateTextBox,
            endDateTextBox, {
                minInterval: (1000 * 60 * 30), // 0.5hr
                maxInterval: (1000 * 60 * 60 * 8),
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                start: {}, // start picker options
                end: {} // end picker options					
            }
        )
        };
		
        $("#tech_sig_box").jSignature();
        $("#cust_sig_box").jSignature();
        
        $("#tech_sig_box").bind('change', function(e){ 
            var datapair = $("#tech_sig_box").jSignature("getData", "default");
            $("#technician_signature").val(datapair);
        });

        $("#cust_sig_box").bind('change', function(e){ 
            var datapair = $("#cust_sig_box").jSignature("getData", "default");
            $("#customer_signature").val(datapair);
        });

        //Lift checkbox validation
        $(".chk_lifts").on("click",function(event,ui)
        {
            $("#liftcheck").val(1);
        });     

         
    });
</script>
<script>
