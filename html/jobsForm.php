
<h1>Jobs</h1>
<p><a href="<?=URL?>/jobs" class="button-primary">Back to jobs</a></p>
<h5><?=$this->model->job_name?></h5>
<label>Key access:</label> <?=$this->model->job_key_access?><br>
<label>Important Notes:</label> <?=$this->model->important_notes?><br>
<div class="row">
    <div class="three columns">

        <label>Visit Frequency:</label> <?=$this->model->frequency_name?><br>
        <label>Agent:</label> <?=$this->model->agent_name?><br>
        <label>Technicians:</label> <?=$this->model->technician_name?><br>
                         
                
        <label>Job Number:</label> <?=$this->model->job_number?><br>  
         
         
        <label>Contact details:</label> <?=$this->model->job_contact_details?><br>
        <label>Email Contacts:</label>

        <?foreach(explode(";",$this->model->job_email) as $email){?>           
                <?=$email?><br>
        <?}?>
        <label>Lifts/Escalators</label><?dropListForLifts($this->modelMaintenance->list);?><br>
        
        <div id = "divTableTasks"> </div>
    </div>
    <div class="three columns">
        
        <label>Floors:</label> <?=$this->model->job_floors?><br>
        <label>Status:</label> <?=$this->model->status_name?><br> 
        <label>Owner details:</label> <?=$this->model->job_owner_details?><br>           
        <label>Group:</label> <?=$this->model->job_group?><br>           
        <label>Round:</label> <?=$this->model->round_name?><br>              
        <label>Agent contact:</label> <?=$this->model->job_agent_contact?><br>       
        <label>Instant Notifications:</label> <?=$this->model->notify_instant?><br>
        <?
            //here we are going to create objects to use
            if( $this->modelMaintenance->list != null ){                
                foreach($this->modelMaintenance->list as $item)
                {
                    if( $item['lift_id'] != null &&  $item['lift_id'] !=0 )
                    {   
                        generateFullTasks( $item['lift_id'] ,$item['lift_type'] ,$item['task_ids'] ,$item['yearmonth'] ,true );                                      
                    }
                }
            }                    
            ?>
        <br>
                       
    </div>
    <div class="six columns">
        <label>Address:</label>
        <?=$this->model->job_address_number?> <?=ucfirst($this->model->job_address)?><br>         
        <?=$this->model->job_suburb?><br>         
        <?mapper($this->model->job_latitude,$this->model->job_longitude,"test")?>
        
    </div>   
</div>
<script>

function  generateCheckList(liftId)
{
    count=0;
    var inHTML = "";     

    // Burda eger secili liftid nin hidden propertysi  L veya E ye gore tasklari getiricez
    var activeLift = document.getElementById("liftsForJob"); 
    var countCheckedLifts = 0 ; 
    
     
    //liftId =1205;
    var selectedliftType =  "L";

    if( activeLift.selectedIndex > 0)
    {
        selectedliftType = activeLift.options[activeLift.selectedIndex].attributes['lift_type'].value;        
    }
        

    // First get year and traverse months 1 to 12 
    var liftName , liftOriginalName ,taskLength ,liftNameTaskId ;
    var emptyTasks ; 
    var d = new Date();

    if (selectedliftType == "E")
    {
        liftOriginalName = "escalator_" + liftId + "_"  + d.getFullYear();
        taskLength = 35;        
        var emptyTasks  = JSON.parse(JSON.stringify( escalatorstasks)); 
    }
    else
    {   
        liftOriginalName = "lift_" + liftId + "_"  + d.getFullYear();
        taskLength = 42;
        var emptyTasks  = JSON.parse(JSON.stringify( liftstasks));      
    }


    var tableTasks = "<table width= '100%' id='jobtable'> " +
        "<thead>" +
        "   <tr> <th>Task Id</th> <th>Task Name</th> <th> Jan</th><th> Feb</th><th> Mar</th><th> April</th><th> May</th><th>June</th><th>July</th><th>Aug</th><th>Sep</th><th> Oct</th><th>Nov</th><th>Dec</th></tr> " +
        "</thead>" +
        "<tbody>" ;

            var no ;
            for( var i = 0 ; i < taskLength ; i++ )
            {
                no = i +1 ;
                tableTasks = tableTasks + "<tr><td>" + no + "</td><td>" + emptyTasks[i]['task_name'] + "</td>";
                
                for(var k = 1 ; k <= 12 ; k++ )     
                {    
                    month = 'month' + k;
                    if( k < 10 )
                    {
                        liftName = liftOriginalName + "0" + k;
                    }
                    else
                    {
                        liftName = liftOriginalName +  k;                        
                    }

                    liftNameTaskId = liftName + "_" + k + "_" + i ;

                    try
                    {
                        var liftName = eval( liftName);
                    }
                    catch(err)
                    { liftName = null;}
                    
                    
                    

                    if( liftName == null )
                    {
                        taskVal = 0 ;// Bu deisecek cunku bazi aylar da 1 bazi aylarda 0 getiricez
                        checkVal = 'unchecked';
                        if( emptyTasks[i][month] != null)  taskVal = emptyTasks[i][month] ;
                        
                        if(taskVal == 1)
                        {
                            checkVal = 'checked';
                            tableTasks = tableTasks + "<td><div class='checkboxFourEmpty'> <input type='checkbox'  " + checkVal + " style ='visibility:hidden;' > </input><label for='checkboxFourInputEmpty' id ='" + liftNameTaskId + "'></div> </td>";                                           
                        }
                        else
                            tableTasks = tableTasks + "<td><div class='checkboxFourEmpty'> <input type='checkbox'  " + checkVal + " style ='visibility:hidden;' > </input><label for='checkboxFourInputEmpty' id ='" + liftNameTaskId + "'></div> </td>";                            
                       
                    }
                    else
                    {
                        taskVal = 0 ;// Bu deisecek cunku bazi aylar da 1 bazi aylarda 0 getiricez
                        checkVal = 'unchecked';
                        
                        //escalator_1205_201901    
                        if( liftName[i][month] != null)  taskVal = liftName[i][month] ;
                        if(taskVal == 1) 
                        {
                            checkVal = 'checked';
                            tableTasks = tableTasks + "<td><div class='checkboxFour'> <input type='checkbox'  " + checkVal + " style = 'visibility:hidden;' ></input><label for='checkboxFourInput' id ='" + liftNameTaskId +  "' ></div></td>";        
                        }
                        else
                        {
                            //if they are already 1 s in emptyTasks ,there should be black cells ,if they are 0s in emptyTasks we print red ones meaning unfinished yet  
                            if(  emptyTasks[i][month] == 1 )
                                tableTasks = tableTasks + "<td><div class='checkboxFour'> <input type='checkbox'  " + checkVal + " style = 'visibility:hidden;' ></input><label for='checkboxFourInput' id ='" + liftNameTaskId +  "' ></div></td>";                                    
                            else
                                tableTasks = tableTasks + "<td><div class='checkboxFour2'> <input type='checkbox'  " + checkVal + " style = 'visibility:hidden;' ></input><label for='checkboxFourInput2' id ='" + liftNameTaskId +  "' ></div></td>";        
                        }
                        
                        
                    }
                
                }
                tableTasks = tableTasks + "</tr>";
            }

            
            tableTasks = tableTasks + "</tbody></table> ";
            //alert(tableTasks);
            document.getElementById("divTableTasks").innerHTML  = tableTasks; 

            
}
</script>   


    <script>
    $(document).ready(function(){
        

    //    alert('burdayiz');
    
		
        
    });
</script>
