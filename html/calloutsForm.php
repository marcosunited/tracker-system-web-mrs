<?
    $disabled = "";
    if($this->model->callout_status_id == 2)
            $disabled = "DISABLED"
    
?>

<h1>Callouts</h1>
<p><a href="<?=URL?>/callouts" class="button-primary">Back to callouts</a></p>

<form role="form" action="<?=URL?>/callouts/action/" method="post" enctype="multipart/form-data">
        <input type="hidden" name="callout_id" placeholder="callout_id"  value="<?=$this->model->callout_id?>">                 
        <input type="hidden" name="is_printed" placeholder="is_printed"  value="<?=$this->model->is_printed?>">
        <input type="hidden" name="user_id" placeholder="user_id"  value="<?=$this->model->user_id?>">
        <input type="hidden" name="updated" placeholder="updated"  value="<?=$this->model->updated?>">
        <input type="hidden" name="accepted_id" placeholder="accepted_id"  value="<?=$this->model->accepted_id?>">
        <input type="hidden" name="technician_id" placeholder="technician_id"  value="<?=$this->model->technician_id?>">
        <input type="hidden" name="job_id" value="<?=$jobs->model->job_id?>">
        
        <label>Callout For:</label><h5><?=$jobs->model->job_name?> - <?=$jobs->model->job_address_number?> <?=$jobs->model->job_address?></h5>
        <label>Callout Id: </label><?=$this->model->callout_id?><br> 
		<label>Contract: </label><?=$jobs->model->contract_name?><br>
		<label>Key Access: </label><?=$jobs->model->job_key_access?><br>    		
        <label>Contact Details: </label><input autocomplete="off" <?=$disabled?>  required type="text" id="contact_details" name="contact_details" placeholder="contact_details"  value="<?=$this->model->contact_details?>"><br>            
        <label>Staus</label><?dropList('_callout_status','callout_status_id','callout_status_name',$this->model->callout_status_id);?><br>
        <label>Order number: </label><input autocomplete="off" <?=$disabled?>  required type="text" name="order_number" placeholder="order_number"  value="<?=$this->model->order_number?>"><br>
        <label>Docket number: </label><input autocomplete="off" <?=$disabled?>  required type="text" name="docket_number" placeholder="docket_number"  value="<?=$this->model->docket_number?>"><br> 
        
        <?
            $where = "where type <> 'Escalator'";
            if(strstr($jobs->model->job_name,"Escalators"))
                $where = "where type <> 'Lift'";

        ?>
        <label>Fault (Complaint): </label><?dropList('_faults','fault_id','fault_name',$this->model->fault_id,$where);?>                
        <label>Priority: </label><?dropList('_priorities','priority_id','priority_name',$this->model->priority_id);?><br>
        <label>Callout Time: </label><input id="callout_time" autocomplete="off" <?=$disabled?>  required type="datetime-local" class="date" name="callout_time" placeholder="callout_time"  value="<?=toDateTime($this->model->callout_time)?>"><br>                   
        <label>Floor no: </label><input autocomplete="off" <?=$disabled?>  required type="text" name="floor_no" placeholder="floor_no"  value="<?=$this->model->floor_no?>"><br>                                      
        <label>Call Description: </label><textarea autocomplete="off" <?=$disabled?>  required name="callout_description" placeholder="callout_description" ><?=$this->model->callout_description?></textarea>         
        
        <label>For Unit(s): </label>
        <input name="liftcheck" id="liftcheck" style="width:1px;height:1px;border:0px;">
        <div id="lifts"><?checkList('lifts','lift_id','lift_name',$this->model->lift_ids,'where job_id = '.$jobs->model->job_id." order by lift_name ASC");?></div>
        
        <h5>Tech Details</h5>
        <label>Time of arrival: </label><input id="toa" autocomplete="off" <?=$disabled?>  required class="date" type="datetime-local" name="time_of_arrival" placeholder="time_of_arrival"  value="<?=toDateTime($this->model->time_of_arrival)?>"><br>     
        <label>Rectification time: </label><input id="rot" autocomplete="off" <?=$disabled?>  required class="date" type="datetime-local" name="rectification_time" placeholder="rectification_time"  value="<?=toDateTime($this->model->rectification_time)?>"><br>              
        <label>Time of departure: </label><input id="tod" autocomplete="off" <?=$disabled?>  required class="date" type="datetime-local" name="time_of_departure" placeholder="time_of_departure"  value="<?=toDateTime($this->model->time_of_departure)?>"><br>

        <?
            $where = "where tech_hidden is null and type <> 'Escalator'";
            if(strstr($jobs->model->job_name,"Escalators"))
                $where = "where tech_hidden is null AND type <> 'Lift'";
        ?>        
        <label>Fault Found (Cause): </label><?dropList('_technician_faults','technician_fault_id','technician_fault_name',$this->model->technician_fault_id,$where);?><br>
        
        
        <?
            $where = "where type <> 'Escalator'";
            if(strstr($jobs->model->job_name,"Escalators"))
                $where = "where type <> 'Lift'";

        ?>
        <label>Correction: </label><?dropList('_corrections','correction_id','correction_name',$this->model->correction_id,$where);?> 
        
        <?
            if($this->model->attributable_id==null)
                $where = "";
        ?>
        
        
        
        <label>Tech Description: </label><textarea autocomplete="off" <?=$disabled?>  required name="tech_description" placeholder="tech_description" ><?=$this->model->tech_description?></textarea><br>
        <label>Part Description: </label><textarea autocomplete="off" <?=$disabled?> id="partd" name="part_description" placeholder="part_description" ><?=$this->model->part_description?></textarea><br>
        <label>Chargeable: </label><?dropList('_chargeable','chargeable_id','chargeable_name',$this->model->chargeable_id);?>
		<label>Photo: </label><input type="file" name="file"  id="file">
		<img src="<?=URL?>/public/uploads/<?=$this->model->photo_name?>" width="250px" height="250px">

        <label>Reported Customer: </label>
        <input autocomplete="off" <?=$disabled?>  required type="text" name="reported_customer" placeholder="reported_customer"  value="<?=$this->model->reported_customer?>"><br> 
               
        
        <label>Notify Email: </label><input id="notify_email" autocomplete="off" <?=$disabled?>  required type="text" name="notify_email" placeholder="notify_email"  value="<?=$this->model->notify_email?>"><br>
        <label>Technician Email: </label><?=$user_email?><br>
		<input type="submit" class="button-primary" value="Save" <?=$disabled?>>
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

        document.getElementById("partd").defaultValue = "No Parts Required";   
    });
</script>
<script>
