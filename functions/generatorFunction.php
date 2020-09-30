<?

    function genFiles($table){
        $controller_field_names = array();
        $field_names = array();
        $field_types = array();
        $field_variables = array();
        $field_define = "";
        $result = mysqli_query(db::$conn,"select * from $table");
        $fields = mysqli_fetch_fields($result);
        
        $i=0;
            
        foreach($fields as $field){

                $quotes = "";
                $zero = "";
                
                if($field->type == 252)
                    $quotes = "'";
                    
                if($field->type != 252)
                    $zero = "0";    
                
                $field_defines[$i] = '$'.$field->name;
                $create_field_names[$i] = $field->name;
                $form_field_names[$i] = $field->name;
                $field_names[$i] = $field->name;
                $controller_field_names[$i] = $field->name;
                $field_variables[$i] = $quotes.$zero.'$this->'.$field->name.$quotes;
                $create_field_variables[$i] = $quotes.$zero.'$this->'.$field->name.$quotes;
                $field_set[$i] = $field->name."=".$quotes.$zero."$".$field->name.$quotes;
            
            $i++;
        }

        $field_names = implode(",",$field_names);
        $field_variables_var = implode(",",$field_variables);

        unset($create_field_names[0]);
        unset($create_field_variables[0]);
        $create_field_names = implode(",",$create_field_names);
        $create_field_variables_var = implode(",",$create_field_variables);        
        
        
?>

<?ob_start();?>
<?="<?";?>                
    class <?=$table?>Model
    {
    <?foreach($field_defines as $field_define){?>
    public <?=$field_define?>; <?="\n"?>
    <?}?>
    public $list;

        function create()
        {
            return db::query("INSERT INTO <?=$table?> (<?=$create_field_names?>) VALUES (<?=$create_field_variables_var?>);");
        }
        
        function read($id)
        {
            $<?=rtrim($table, "s")?> = db::query("select * from <?=$table?> where <?=rtrim($table, "s")?>_id = $id");     
            <?$field_names = explode(",",$field_names)?>           
            if($<?=rtrim($table, "s")?>){
                $<?=rtrim($table, "s")?> = $<?=rtrim($table, "s")?>[0]; 
               <?foreach($field_names as $field_name){?>
 $this-><?=$field_name?> = $<?=rtrim($table, "s")?>['<?=$field_name?>'];<?="\n"?>
               <?}?>
 return true;
            }
           
            return false;
        }
        
        function update()
        {
            $query = "UPDATE <?=$table?> SET
    <?$i=1?>
    <?unset($field_names[0])?>
        <?while($i<=sizeof($field_names)){?>
      <?=$field_names[$i]?> = <?=$field_variables[$i]?><?if($i<sizeof($field_names)){echo ",";}?>
        <?="\n"?>
        <?$i++?>
        <?}?>
      WHERE <?=rtrim($table, "s")?>_id = $this-><?=rtrim($table, "s")?>_id
            ";
            return db::query($query);
        }
        
        function delete($id = null)
        {
            if($id)
                return db::query("delete from <?=$table?> where <?=rtrim($table, "s")?>_id = $id");
            return db::query("delete from <?=$table?> where <?=rtrim($table, "s")?>_id = $this-><?=rtrim($table, "s")?>_id");
        }

        function readAll()
        {
            $this->list = db::query('select * from <?=$table?>');
        }        
    }
<?="?>"?>
<?$contents = ob_get_contents();?>               


<?php
    $myfile = fopen("public/generated/".$table."Model.php", "w") or die("Unable to open file!");
    ob_end_clean();
    fwrite($myfile, $contents);
    fclose($myfile);
?> 

<?ob_start();?>
<?="<?"?>
    
    class <?=$table?>View extends view
    {
        public $model;

        function __construct(<?=$table?>Model $model)
        {
          $this->model = $model;
        }
    }
<?="?>"?>

<?php
    $contents = ob_get_contents();
    $myfile = fopen("public/generated/".$table."View.php", "w") or die("Unable to open file!");
    ob_end_clean();
    fwrite($myfile, $contents);
    fclose($myfile);
?>


<?ob_start();?>
<?="<?\n"?>
    class <?=$table?><?="\n"?>
    {   
        private $model;
        private $view;
        
        function __construct()
        {
            $this->model = new <?=$table?>Model();
            $this->view = new <?=$table?>View($this->model);        
        }
        
        function index()
        {          
            $this->model->readAll();
            $this->view->render('<?=$table?>Table');
        }
        
        function form()
        {
            $this->model->read(req('id'));
            $this->view->render('<?=$table?>Form');
        }
        
        function action()
        {
            <?foreach($controller_field_names as $field_name){?>
$this->model-><?=$field_name?> = req('<?=$field_name?>');<?="\n"?>
            <?}?>
                
            if(req('<?=rtrim($table, "s")?>_id'))
            {
                $this->model->update();
                sess('alert','<?=ucfirst(rtrim($table, "s"))?> Updated');
                redirect(URL.'/<?=$table?>/form/'.req('<?=rtrim($table, "s")?>_id'));
            }else{
                $this->model->create();
                sess('alert','<?=ucfirst(rtrim($table, "s"))?> Created');
                redirect(URL.'/<?=$table?>/form/');           
            }
        }
        
        function delete()
        {
            $this->model->delete(req('id'));
            sess('alert','<?=ucfirst(rtrim($table, "s"))?> Deleted');
            redirect(URL.'/<?=$table?>');
        }
    }
<?="?>"?>

<?php
    $contents = ob_get_contents();
    $myfile = fopen("public/generated/".$table.".php", "w") or die("Unable to open file!");
    ob_end_clean();
    fwrite($myfile, $contents);
    fclose($myfile);
?>



<?$create_field_names = explode(",",$create_field_names);?>


<?ob_start();?>

    <h1><?=ucfirst(rtrim($table, "s"))?> List</h1>
    
    <p><a href="<?echo '<?=URL?>'?>/<?=$table?>/form/" class="button-primary">New <?=rtrim($table, "s")?></a></p>
    
    <table width="100%">
        <thead>
            <tr>
                <?foreach($create_field_names as $field_name){?>
<?$header = str_replace(rtrim($table, "s")."_","",$field_name)?>
<?$header = str_replace("_"," ",$header)?>
<th><?=ucfirst($header)?></th>
                <?}?>
<th></th>
            </tr>
        </thead>
        <tbody>
        <?echo '<?foreach($this->model->list as $'.rtrim($table, "s").'){?>';?>
            
            <tr>
                <?foreach($create_field_names as $field_name){?>
<td><?="<?=$".rtrim($table, "s")."['".$field_name."']?>"?>  </td>
                <?}?>
                
                <td>
                    <a href="<?echo'<?=URL?>';?>/<?=$table?>/form/<?echo "<?=$".rtrim($table, "s")."['".rtrim($table, "s")."_id']?>";?>">Edit</a> | 
                    <a href="<?echo'<?=URL?>';?>/<?=$table?>/delete/<?echo "<?=$".rtrim($table, "s")."['".rtrim($table, "s")."_id']?>";?>" class="confirm">Delete</a>                   
                </td>
            </tr>
        <?echo '<?}?>'."\n";?>
        </tbody>
    </table>
    
<?php
    $contents = ob_get_contents();
    $myfile = fopen("public/generated/".$table."Table.php", "w") or die("Unable to open file!");
    ob_end_clean();
    fwrite($myfile, $contents);
    fclose($myfile);
?>



<?ob_start();?>
<h1><?=ucfirst($table)?></h1>
<p><a href="<?='<?=URL?>'?>/<?=$table?>" class="button-primary">Back to <?=$table?></a></p>

<form role="form" action="<?='<?=URL?>'?>/<?=$table?>/action/" method="post">
    <input type="hidden" name="<?=rtrim($table, "s")?>_id" value="<?='<?=$this->model->'.rtrim($table, "s").'_id?>'?>">

    <?foreach($form_field_names as $field_name){?>
        <?$header = str_replace(rtrim($table, "s")."_","",$field_name)?><?$header = str_replace("_"," ",$header)?>    
        <label><?=ucfirst($header)?>: </label><input type="text" name="<?=$field_name?>" placeholder="<?=$field_name?>" class="form-control" value="<?='<?=$this->model->'.$field_name.'?>'?>"><?="<br>\n"?>
        <?}?>
    <input type="submit" class="button-primary" value="Save">
</form>

<?php
    $contents = ob_get_contents();
    $myfile = fopen("public/generated/".$table."Form.php", "w") or die("Unable to open file!");
    ob_end_clean();
    fwrite($myfile, $contents);
    fclose($myfile);
?>

<?}?>
