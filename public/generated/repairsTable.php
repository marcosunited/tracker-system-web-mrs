
    <h1>Repair List</h1>
    
    <p><a href="<?=URL?>/repairs/form/" class="button-primary">New repair</a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <th>Job id</th>
                <th>Technician id</th>
                <th>Status id</th>
                <th>Lift ids</th>
                <th>Description</th>
                <th>Tech details</th>
                <th>Parts required</th>
                <th>Time of arrival</th>
                <th>Time of departure</th>
                <th>Chargeable id</th>
                <th>Quoted price</th>
                <th>Time</th>
                <th>Notify email</th>
                <th>Parts description</th>
                <th>Updated</th>
                <th>User id</th>
                <th>Quote no</th>
                <th>Order no</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $repair){?>            
            <tr>
                <td><?=$repair['job_id']?>  </td>
                <td><?=$repair['technician_id']?>  </td>
                <td><?=$repair['repair_status_id']?>  </td>
                <td><?=$repair['lift_ids']?>  </td>
                <td><?=$repair['repair_description']?>  </td>
                <td><?=$repair['tech_details']?>  </td>
                <td><?=$repair['parts_required']?>  </td>
                <td><?=$repair['time_of_arrival']?>  </td>
                <td><?=$repair['time_of_departure']?>  </td>
                <td><?=$repair['chargeable_id']?>  </td>
                <td><?=$repair['quoted_price']?>  </td>
                <td><?=$repair['repair_time']?>  </td>
                <td><?=$repair['notify_email']?>  </td>
                <td><?=$repair['parts_description']?>  </td>
                <td><?=$repair['updated']?>  </td>
                <td><?=$repair['user_id']?>  </td>
                <td><?=$repair['quote_no']?>  </td>
                <td><?=$repair['order_no']?>  </td>
                                
                <td>
                    <a href="<?=URL?>/repairs/form/<?=$repair['repair_id']?>">Edit</a> | 
                    <a href="<?=URL?>/repairs/delete/<?=$repair['repair_id']?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
    
