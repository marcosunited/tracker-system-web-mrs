<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
    <h1>Repairs Table</h1>

    
    <table width="100%" id="maintable">
        <thead>
            <tr>
                <th>Time</th>
                <th>Job Address<th>
                <th>Unit</th>
                <th>Time Frame Status</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $repair){?>            
            <tr>
                <td><?=toDate($repair['repair_time'],"human")?></td>
                <td><?=$repair['job_address_number']?> <?=ucFirst($repair['job_address'])?> <?=ucFirst($repair['job_suburb'])?>  </td>
                <td>  </td>
                <td><?=getLifts($repair['lift_ids'])?></td>
                <td><?=$repair['repair_status_name']?></td>      
                <td>
                    <a href="<?=URL?>/repairs/form/<?=$repair['repair_id']?>" class="button-primary">View</a>          
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>

    <script>
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        if (a == null || a == "") {
            return 0;
        }
        var ukDatea = a.split('-');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
 
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );
    </script>
        <script>
        $(document).ready(function() {
            $('#maintable').DataTable({
                "order": [
                    [0, "asc"]
                ],
                columnDefs: [
       { type: 'date-uk', targets: 0 }
     ],
                paging: false,
                searching: true,

            });
        });
    </script>
