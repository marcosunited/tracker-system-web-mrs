
    <h1>User List</h1>
    
    <p><a href="<?=URL?>/users/form/" class="btn btn-primary">New user</a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Realname</th>
                <th>Auth level</th>
                <th>Image</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model1->list as $user){?>            
            <tr>
                <td><?=$user['username']?>  </td>
                <td><?=$user['password']?>  </td>
                <td><?=$user['realname']?>  </td>
                <td><?=$user['auth_level']?>  </td>
                <td><?=$user['image']?>  </td>
                <td><?=$user['user_email']?>  </td>
                                
                <td>
                    <a href="<?=URL?>/users/form/<?=$user['user_id']?>">Edit</a> | 
                    <a href="<?=URL?>/users/delete/<?=$user['user_id']?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
    
