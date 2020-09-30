

<style>
    .checkboxFive {
    width: 0px;
    height: 0px;
    background: #ddd;
    margin: 20px 90px;

    border-radius: 100%;
    position: relative;
    box-shadow: 0px 1px 3px rgba(0,0,0,0.5);
}

.checkboxFive label {
    display: block;
    width: 30px;
    height: 30px;
    border-radius: 100px;

    transition: all .5s ease;
    cursor: pointer;
    position: absolute;
    top: -20px;
    left: 5px;
    z-index: 1;

    background:  rgb(231, 48, 48);
    box-shadow:inset 0px 1px 3px rgba(0,0,0,0.5);
}


.checkboxFive input[type=checkbox]:checked + label {
    background: #26ca28;
}

input[type='radio'] {
    border: 1px;
    width: 100%;
    height: 2em;
}

</style>
<script>


function showTask(month) {
    if (month == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert( this.responseText );
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","gettask.php?q="+month,true);
        xmlhttp.send();
    }
}
function validateChecks()
{
    count=0;
    
    // Burda eger secili liftid nin hidden propertysi  L veya E ye gore tasklari getiricez
    var allLifts = document.getElementsByClassName("chk_lifts"); 
    var countCheckedLifts = 0 ; var selectedliftType = "L" ;// by default
    var maintanedlftId = document.getElementById('maintaned_lftId').value;
    var activeLiftId ;

    var signCheck = document.getElementById("signCheck");
    var sign_and_print = document.getElementById("sign_and_print");
    
    for(var i = 0 ; i < allLifts.length ;i++ )     
    {                
        if( allLifts[i].checked)
        {
            countCheckedLifts++; activeLiftId = allLifts[i].value;
        }         
    }

    if( signCheck == null || signCheck.checked == false)
    {
        if(countCheckedLifts == 0)
        {
            alert("You need to select a lift to see the task list!");
            return false;
        }
        if(countCheckedLifts != 1)
        {
            alert("You need to select only one lift to see the task list!");
            return false;
        }

        var checkboxes = $("input:checkbox"); 
        var isAnyTaskChecked = false;
        
        var i;
        for (i = 0; i < checkboxes.length; i++) 
        {
            if ( checkboxes[i].id.startsWith("task_id") ) 
            {
                if(checkboxes[i].checked) 
                {
                    isAnyTaskChecked = true;
                    break;
                }
            }
        }

        if(isAnyTaskChecked == false)
        {
            alert("You should select at list 1 task completed!");
            return false;
        }

        // if this is an update  operation ,lift id should not be updated
        if( document.getElementById('maintenance_id').value != "" )
        {
            if( activeLiftId != maintanedlftId)
            {
                alert("Lift can not be updated,please do not try to change lift for the maintenance!You can create new maintenance for different lift.");
                return false;
            }
        }
    }
    else
    {
        if( sign_and_print.selectedIndex == 0)
        {
            alert("While signing ,you need to provide customer name or customer signature!");
            return false;
        }

        if( document.getElementById('active_month').selectedIndex <= 0)
        {
            alert("While signing ,month should be selected!");
            return false;
        }
        if (countCheckedLifts > 0 )
        {
            alert("While signing ,no lift can be selected ,please deselect lift.");
            return false;
        }       
        if( document.getElementById('notify_email').value == "" )       
        {   
            alert("While signing ,an email address should be provided!");
            return false;
        } 
    }

    return true;
}
function showSignPart()
{
    if( document.getElementById('signCheck').checked == true)
    {
        document.getElementById('divSignPrint').style.display = "block";
        document.getElementById('save').value = "close";        
        emptyTaskList();
        document.getElementById('lblNotifyEmail').style.display = "block";
        document.getElementById('notify_email').style.display = "block";
        document.getElementById('lblTechnicianEmail').style.display = "block";
        document.getElementById('technician_email').style.display = "block";
    }
    else
    {
        document.getElementById('divSignPrint').style.display = "none";
        document.getElementById("tblselectAllTasks").style.display = "block";
        document.getElementById('save').value = "save"; 
        document.getElementById('lblNotifyEmail').style.display = "none";
        document.getElementById('notify_email').style.display = "none";
        document.getElementById('lblTechnicianEmail').style.display = "none";
        document.getElementById('technician_email').style.display = "none";       
     
    }
}

function emptyTaskList()
{
    document.getElementById("txtHit").innerHTML  = "";
    document.getElementById("tblselectAllTasks").style.display = "none";
}

function checkAllTasks()
{
    var allTasksCheck = document.getElementById("selectAllTasks");
    var checkboxes = $("input:checkbox");

    var i; var count = 0 ;
    for (i = 0; i < checkboxes.length; i++) 
        if ( checkboxes[i].id.startsWith("task_id") ) count++ ;                            
    

    if(count == 0)
    {
        alert("No task is listed yet, to see the task list you should select a month .");
        allTasksCheck.checked =false;        
        return;
    }    

    if(allTasksCheck.checked)
    {                 
        var i;
        for (i = 0; i < checkboxes.length; i++) 
        {
            if ( checkboxes[i].id.startsWith("task_id") ) 
                checkboxes[i].checked =true ;                            
        }
    }
    else
    {
        var i;
        for (i = 0; i < checkboxes.length; i++) 
        {
            if ( checkboxes[i].id.startsWith("task_id") ) 
                checkboxes[i].checked = false ;                            
        }
    }
}

function  generateCheckList(month)
{
    count=0;
    var inHTML = "";     

    // Burda eger secili liftid nin hidden propertysi  L veya E ye gore tasklari getiricez
    var allLifts = document.getElementsByClassName("chk_lifts"); 
    var countCheckedLifts = 0 ; var selectedliftType = "L" ;// by default
    
    var signCheck = document.getElementById("signCheck");
    if(signCheck.checked) return;

    for(var i = 0 ; i < allLifts.length ;i++ )     
    {                
        if( allLifts[i].checked) countCheckedLifts++;        
    }

    if(countCheckedLifts == 0)
    {
        alert("You need to select a lift to see the task list!");
        document.getElementById('active_month').selectedIndex = 0;
        return;
    }
    if(countCheckedLifts != 1)
    {
        alert("You need to select only one lift to see the task list!");
        return;
    }
    else
    {
        for(var i = 0 ; i < allLifts.length ;i++ )     
        {                
            if( allLifts[i].checked) 
            {
                selectedliftType = allLifts[i].attributes['lift_type'].value ;
                break;
            }                    
        }
    }    

    

    inHTML = '<table>'    
    if (selectedliftType == "E")
    {
        for(var i = 0 ; i < escalatorstasks.length ;i++ )     
        {                
            if( escalatorstasks[i][month] == "0")
            {
                inHTML = inHTML + '<tr><td>' + escalatorstasks[i]['task_name'] + "</td><td><div class='checkboxFive'><input name = '"  + 
                        "task_id_" + escalatorstasks[i]['task_id']  + "' id= 'task_id_" + escalatorstasks[i]['task_id'] + "' type='checkbox'  style ='visibility:hidden' value = '" + escalatorstasks[i]['task_id'] + "' /><label for= 'task_id_" + escalatorstasks[i]['task_id'] + "'></label></div></td></tr>";        
            }        
            count++;
        }
    }
    else
    {
        for(var i = 0 ; i < liftstasks.length ;i++ )     
        {                
            if( liftstasks[i][month] == "0")
            {
                inHTML = inHTML + '<tr><td>' +  liftstasks[i]['task_name'] +"</td><td><div class='checkboxFive'><input name = '"  + 
                        "task_id_" + liftstasks[i]['task_id']  + "' id= 'task_id_" + liftstasks[i]['task_id'] + "' type='checkbox' style ='visibility:hidden' value = '" + liftstasks[i]['task_id'] + "' /><label for= 'task_id_" + liftstasks[i]['task_id'] + "'></label></div></td></tr>";        
            }        
            count++;
        }
    }
    inHTML = inHTML + '</table>';

    document.getElementById("txtHit").innerHTML  = inHTML;      
    return ;
}

function showCustomerRelatedAreas(customerSignatureShow ,nosignShow ) {
    document.getElementById("divCustomerSignature").style.display = customerSignatureShow;
    document.getElementById("divCustomerSignatureLbl").style.display = customerSignatureShow;


    //document.getElementById("cust_sig_box").style.display = customerSignatureShow;
    if(document.getElementById("divCustomerSignatureImg") != null )
        document.getElementById("divCustomerSignatureImg").style.display = customerSignatureShow;
    else
        document.getElementById("cust_sig_box").style.display = customerSignatureShow;
    
    document.getElementById("divNosignNeeded").style.display = nosignShow ;
    document.getElementById("divNosignCustomerName").style.display = nosignShow ;
    document.getElementById("customer_name").style.display = nosignShow ;
}

function showSignature(choice) {
    var signPrintSelect = document.getElementById("sign_and_print");

    if (signPrintSelect.selectedIndex == 0) {
        showCustomerRelatedAreas( "none" ,"none" );        
    } else if (signPrintSelect.selectedIndex == 1) {
        showCustomerRelatedAreas( "block" ,"none" );        
    } else if (signPrintSelect.selectedIndex == 2) {
        showCustomerRelatedAreas( "none" ,"block"  );
    }

}


function showTask2(month)
{

    $.ajax({
        url: "gettask.php",
        type: "post",
        data: month ,
        success: function (response) {
           // you will get response from your php page (what you echo or print)         
            alert('ok')  ;
            alert(response[0] );
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }

    });
}

</script>

<h1>Maintenance</h1>
<p><a href="<?=URL?>/maintenance" class="button-primary">Back to maintenance</a></p>
<label>Maintenance Call for</label>
<h5><?=$jobs->model->job_name?> - <?=$jobs->model->job_address_number?> <?=$jobs->model->job_address?></h5>


<form role="form" action="<?=URL?>/maintenance/action/" method="post">
        <input type="hidden" id = "maintenance_id"  name="maintenance_id" value="<?=$this->model->maintenance_id?>">
        <input type="hidden" name="technician_id" placeholder="technician_id" class="form-control" value="<?=sess('user_id')?>">
        <input type="hidden" name="job_id" placeholder="job_id" class="form-control" value="<?=$jobs->model->job_id?>">
        <input type="hidden" name="updated" placeholder="updated" class="form-control" value="<?=time()?>">         
        <input type="hidden" name="user_id" placeholder="user_id" class="form-control" value="<?=$jobs->model->job_id?>">
        <input type="hidden" name="yearmonth" id = "yearmonth" class="form-control" value="<?=$this->model->yearmonth?>">
        <input type="hidden" name="maintaned_lftId" id = "maintaned_lftId" class="form-control" value="<?=$this->model->lift_id?>">

        <label>Date: </label><input id="maintenance_date" type="datetime-local" class="date" name="maintenance_date" placeholder="maintenance_date" class="form-control" value="<?=toDateTime($this->model->maintenance_date)?>" <?=$disabled?> required ><br>        
        
        <?if($this->model->docket_no > 0 ) {?>
            <label>Docket no: </label><input type="text" id = "docket_no" name="docket_no" placeholder="docket_no" class="form-control" value="<?=$this->model->docket_no?>" <?=$disabled?>  ><br>    
        <?}else {?>
            <label>Docket no: </label><input type="text" id = "docket_no" name="docket_no" placeholder="manual docket no if required" class="form-control"  <?=$disabled?>  ><br>    
        <?}?>

        <?if($this->model->order_no > 0 ) {?>
            <label>Order no: </label><input type="text" id = "order_no" name="order_no" placeholder="order_no" class="form-control" value="<?=$this->model->order_no?>" <?=$disabled?>  ><br>              
        <?}else {?>    
            <label>Order no: </label><input type="text" id = "order_no" name="order_no" placeholder="client order no if required" class="form-control"  <?=$disabled?>  ><br>              
        <?}?>
        
        <label>Lift ids: </label>
        <input name="liftcheck" id="liftcheck" style="width:1px;height:1px;border:0px;">
        <?checkListForLifts('lifts','lift_id','lift_name',$this->model->lift_ids,'where job_id = '.$jobs->model->job_id , $disabled);?>
        Select Sign once the tasks have been completed for that visit on all lifts
        <? if( !( $this->model->maintenance_id > 0)) { ?>
                <table>        
                <tr>
                <td>Signature</td>
                <td> <div class='checkboxFive'>
                        <input name='signCheck' 
                                id='signCheck' type='checkbox' 
                                onclick= 'showSignPart()'
                                style ='visibility:hidden' 
                                <?=$disabled?> 
                                >                             
                        </input>
                        <label for = 'signCheck' ></label>
                    </div>
                </td>
                </tr>
                </table>
        <br>
        <?}?>

        
        


        <div id = "divSignPrint" >
        <label>Sign and Print: </label>
        <select id = "sign_and_print" name="sign_and_print"  <?=$disabled?> >
		  <option value="0">Select sign/no sign:</option>
		  <option value="1">Customer Signature</option>
		  <option value="2">No signature available</option>		  		  
		 </select>   

        <div id = "divCustomerSignature"  >
            <label id= "divCustomerSignatureLbl" >Customer signature:</label>
            <input type="hidden" id="customer_signature" name="customer_signature" type="text" placeholder="customer_signature"  value="<?=$this->model->customer_signature?>" <?=$disabled?> >       
            <?if($this->model->customer_signature == ''){?>
                <div id="cust_sig_box" style="border:1px solid #666"></div>
            <?}else{?>
                <img id ="divCustomerSignatureImg" src="<?=$this->model->customer_signature?>">
            <?}?>
        </div>

        <div id = "divNosignNeeded" > 
            <label id = "divNosignCustomerName" >Customer Name:</label>
            <input type="text" id= "customer_name" name="customer_name" placeholder="customer_name" class="form-control" value="<?=$this->model->customer_name?>" <?=$disabled?>  ><br>      
        </div>

        </div>

        <!-- <label>Technician signature: </label>
        <input type="hidden" id="technician_signature" name="technician_signature" type="text" placeholder="technician_signature"  value="<?=$this->model->technician_signature?>" ><br>
        <?if($this->model->technician_signature == ''){?>
            <div id="tech_sig_box" style="border:1px solid #666;"></div>
        <?}else{?>
            <img src="<?=$this->model->technician_signature?>">
        <?}?>         -->
        
        <label>Time of arrival: </label>
        <input id="toa" type="datetime-local" class="date"  name="maintenance_toa" placeholder="maintenance_toa" class="form-control" value="<?=toDateTime($this->model->maintenance_toa)?>" <?=$disabled?> required ><br>              
       

        <label>Time of departure: </label>
        <input id="tod" type="datetime-local" class="date"  name="maintenance_tod" placeholder="maintenance_tod" class="form-control" value="<?=toDateTime($this->model->maintenance_tod)?>" <?=$disabled?> required ><br>           
        

         <select id = "active_month" name="active_month" <?=$disabled?> onchange="generateCheckList(this.value)">
		  <option value="">Select montly tasks:</option>
		  <option value="month1">January</option>
		  <option value="month2">February</option>
		  <option value="month3">March</option>
		  <option value="month4">April</option>
		  <option value="month5">May</option>
		  <option value="month6">June</option>
		  <option value="month7">July</option>
		  <option value="month8">August</option>
		  <option value="month9">September</option>
		  <option value="month10">October</option>
		  <option value="month11">November</option>
		  <option value="month12">December</option>		  
		 </select>   

         <br>
         <table>
         <tr><td> Maintenance week:</td>
         <td><label for="radweek1"> week 1</label><input type="radio" id ="radweek1" name="active_week" value="1" />  </td>        
         <td><label for="radweek2"> week 2</label><input type="radio" id ="radweek2" name="active_week" value="2" /> </td>
         <td><label for="radweek3"> week 3</label><input type="radio" id ="radweek3" name="active_week" value="3" /> </td>
         <td><label for="radweek4"> week 4</label><input type="radio" id ="radweek4" name="active_week" value="4" /> </td>
         <td><label for="radweek5"> week 5</label><input type="radio" id ="radweek5" name="active_week" value="5" /></td> </tr>  
         </table>
         <br>
        

        <table id ="tblselectAllTasks">        
        <tr>
        <td> Select All tasks</td>
        <td> <div class='checkboxFive'>
                    <input name='selectAllTasks' 
                             id='selectAllTasks' type='checkbox' 
                             onclick= 'checkAllTasks()'
                             style ='visibility:hidden' >
                    </input>
                    <label for = 'selectAllTasks' ></label>
             </div>
        </td>
        </tr>
        </table>

		<div id="txtHit">
        
        <?
            $dateMounth = null ;
            $where = null ;

            if( $this->model->yearmonth )
            {
                $dateMounth = substr($this->model->yearmonth ,4 ,2);
                if( substr( $dateMounth ,0 , 1 ) == "0" ) $dateMounth = substr( $dateMounth ,1 , 1 ); 
                $where = "where month" . $dateMounth . " = 0 ;";    
            }
             

            if( $this->model->lift_id != null )
            {                
                if( getLiftType( $this->model->lift_id ) == "L" )
                    checkTaskList('_lift_tasks','task_id','task_name',$this->model->task_ids ,$where); 
                else
                    checkTaskList('_escalator_tasks','task_id','task_name',$this->model->task_ids ,$where );             
            }
        ?>
        </div>

        <label>Notes: </label><textarea name="maintenance_notes" placeholder="maintenance_notes" class="form-control" <?=$disabled?>  ><?=$this->model->maintenance_notes?></textarea><br>         
        
        <label id ="lblNotifyEmail" >Notify Email: </label><input id="notify_email" autocomplete="off" <?=$disabled?>  type="text" name="notify_email" placeholder="notify_email"  value="<?=$this->model->notify_email?>"><br>
        <label id ="lblTechnicianEmail" >Technician Email: </label><div id ="technician_email"> <?=$user_email?> </div> <br>
		<input id = "save" type="submit" onclick = "return validateChecks();" class="button-primary" value="Save"  required >
</form>
<script>
    $(document).ready(function(){

        if(!isMobile()){
			$('#maintenance_date').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: true });
            var startDateTextBox = $('#toa');
        var endDateTextBox = $('#tod');

        $.timepicker.datetimeRange(
            startDateTextBox,
            endDateTextBox, {
                minInterval: (1000 * 60 * 30), // 0.5hr
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                start: {}, // start picker options
                end: {} // end picker options					
            }
        ) 
        };
        /*
        document.getElementById('maintenance_date').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: true });
		document.getElementById('toa').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: true });
		document.getElementById('tod').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: true });
		
        if( !( document.getElementById('maintenance_id').value > 0 ) )
        {
            var maintenanceDateTextbox = $('#maintenance_date');
            maintenanceDateTextbox.datetimepicker('setDate', new Date());
            var toaTextbox = $('#toa');
            toaTextbox.datetimepicker('setDate', new Date());
            var todTextbox = $('#tod');
            todTextbox.datetimepicker('setDate', new Date());
        }*/

        $("#sign_and_print").bind('change',function(e)
        {
            showSignature();
        });

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

 
        document.getElementById('divSignPrint').style.display = "none";
        document.getElementById('divCustomerSignature').style.display = "none";
        document.getElementById('divNosignNeeded').style.display = "none";

        document.getElementById('lblNotifyEmail').style.display = "none";
        document.getElementById('notify_email').style.display = "none";
        document.getElementById('lblTechnicianEmail').style.display = "none";
        document.getElementById('technician_email').style.display = "none";
        

        var dateObj = new Date();
        var month = dateObj.getUTCMonth() + 1; //months from 1-12
        var day = dateObj.getUTCDate();

        
        if( day <= 7 )  week = 1 ;
        else if( day <= 14 )  week = 2 ;
        else if( day <= 21 )  week = 3 ;
        else if( day <= 28 )  week = 4 ;
        else week = 5 ;
        
        var weekRadios = document.getElementsByName('active_week');
        for (var j = 0; j < weekRadios.length; j++) {
            if (weekRadios[j].value == week) {
                weekRadios[j].checked = true;
                break;
            }
        }


        //If there is a maintenance id then we are in update mode
        if( document.getElementById('maintenance_id').value != "" )
        {            
            document.getElementById('active_month').disabled = false;

           var dateOfMaintenance = (document.getElementById('yearmonth').value).substring(4) ;
            //we have something like 201905
            if(dateOfMaintenance.startsWith("0") ) 
                dateOfMaintenance = dateOfMaintenance.substring(1); 

            document.getElementById('active_month').selectedIndex = dateOfMaintenance ; 
            //document.getElementById('active_month').onchange();
            document.getElementById('active_month').disabled = true;
        }
        //save button is always enabled
        /*
        if(  document.getElementById('completed_id').options[document.getElementById('completed_id').selectedIndex].text == "Completed" )
            document.getElementById('save').disabled = true;
        else
            document.getElementById('save').disabled = false;
            */
    });
</script>

