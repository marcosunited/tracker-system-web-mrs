
    <h1>_accepted List</h1>
    
    <p><a href="<?=URL?>/_accepted/form/" class="button-primary">New _accepted</a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <th>Accepted name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $_accepted){?>            
            <tr>
                <td><?=$_accepted['accepted_name']?>  </td>
                                
                <td>
                    <a href="<?=URL?>/_accepted/form/<?=$_accepted['_accepted_id']?>">Edit</a> | 
                    <a href="<?=URL?>/_accepted/delete/<?=$_accepted['_accepted_id']?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
    
