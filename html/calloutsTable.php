<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
    <h1>Closed Callout List by you</h1>

    
    <table width="100%" id="maintable">
        <thead>
            <tr>
                <th>Time</th>
                <th>Job Address<th>
                <th>Unit</th>
                <th>Complaint</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $callout){?>            
            <tr>
                <td><?=toDate($callout['callout_time'],"human")?></td>
                <td><?=$callout['job_address_number']?> <?=ucFirst($callout['job_address'])?> <?=ucFirst($callout['job_suburb'])?>  </td>
                <td>  </td>
                <td><?=getLifts($callout['lift_ids'])?></td>
                <td><?=$callout['fault_name']?></td>      
                <td>
                    <a href="<?=URL?>/callouts/form/<?=$callout['callout_id']?>" class="button-primary">View</a>          
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
