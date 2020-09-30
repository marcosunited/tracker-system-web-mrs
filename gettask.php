<!DOCTYPE html>
<html>
<head>
<body>
<?php
$q = intval($_GET['q']);
$where = 'where duration = '".$q."'';

echo "
<input name="taskcheck" id="taskcheck" style="width:1px;height:1px;border:0px;">
<?checkList('_new_tasks','task_id','task_name',$this->model->task_ids,$where);?>" 

?>

</body>
</html>