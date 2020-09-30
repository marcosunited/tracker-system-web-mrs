
    <h1>_statu List</h1>
    
    <p><a href="<?=URL?>/_status/form/" class="button-primary">New _statu</a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <th>Status name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $_statu){?>            
            <tr>
                <td><?=$_statu['status_name']?>  </td>
                                
                <td>
                    <a href="<?=URL?>/_status/form/<?=$_statu['_statu_id']?>">Edit</a> | 
                    <a href="<?=URL?>/_status/delete/<?=$_statu['_statu_id']?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
    
