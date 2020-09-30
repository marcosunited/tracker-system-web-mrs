
    <h1>Menu List</h1>
    
    <p><a href="<?=URL?>/menu/form/" class="btn btn-primary">New menu</a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Class name</th>
                <th>Auth level</th>
                <th>Order</th>
                <th>Parent</th>
                <th>Target</th>
                <th>Level only</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $menu){?>            
            <tr>
                <td><?=$menu['menu_name']?>  </td>
                <td><?=$menu['class_name']?>  </td>
                <td><?=$menu['auth_level']?>  </td>
                <td><?=$menu['menu_order']?>  </td>
                <td><?=$menu['menu_parent']?>  </td>
                <td><?=$menu['menu_target']?>  </td>
                <td><?=$menu['level_only']?>  </td>
                                
                <td>
                    <a href="<?=URL?>/menu/form/<?=$menu['menu_id']?>">Edit</a> | 
                    <a href="<?=URL?>/menu/delete/<?=$menu['menu_id']?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
    
