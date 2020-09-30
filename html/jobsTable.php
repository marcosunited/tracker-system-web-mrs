<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<h1>Job List</h1>
    
    <table width="100%" id="jobtable">
        <thead>
            <tr>

                <th>Name</th>
                <th>Address</th>
               
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $job){?>            
            <tr>
               
                <td><?=ucfirst($job['job_name'])?>  </td>
                <td><?=$job['job_address_number']?> <?=ucFirst($job['job_address'])?> <?=ucFirst($job['job_suburb'])?>  </td>
                
                                
                <td>
                    <a href="<?=URL?>/jobs/form/<?=$job['job_id']?>">View</a> | 
                    <a href="<?=URL?>/callouts/form/?job_id=<?=$job['job_id']?>">Callout</a> | 
                    <a href="<?=URL?>/maintenance/form/?job_id=<?=$job['job_id']?>">Maintenance</a> 
                    <a href="<?=URL?>/repairs/form/?job_id=<?=$job['job_id']?>">Repairs</a> 
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
            <script>
        $(document).ready(function() {
            $('#jobtable').DataTable({
                "order": [
                    [0, "asc"]
                ],
                paging: false,
                searching: true,

            });
        });
    </script>
