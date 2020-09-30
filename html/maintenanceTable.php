<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
    <h1>All Maintenance List </h1>
    
    <table width="100%" id="maintable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Lift ids</th>
                <th>Month</th>  
                <th>Year</th>                                
                <th>Job Address</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?foreach($this->model->list as $maintenance){?>            
            <tr>
                <td><?=toDate($maintenance['maintenance_date'])?>  </td>
                <td><?=getLifts($maintenance['lift_ids'])?>  </td> 
                <td>
                    <?  
                        $year = substr( $maintenance['yearmonth'] ,0 ,4 );
                        $month =  substr( $maintenance['yearmonth'] ,4 ,2 ) ;
                        
                        switch ($month) {
                            case '01':
                                echo "January";
                                break;
                            case '02':
                                echo "February";
                                break;        
                            case '03':
                                echo "March";
                                break;     
                            case '04':
                                echo "April";
                                break;
                            case '05':
                                echo "May";
                                break;   
                            case '06':
                                echo "June";
                                break;
                            case '07':
                                echo "July";
                                break;    
                            case '08':
                                echo "August";
                                break;
                            case '09':
                                echo "September";
                                break;   
                            case '10'  :
                                echo "October";
                                break;     
                            case '11':
                                echo "November";
                                break;
                            case '12':
                                echo "December";
                                break;
                            default:
                                # code...
                                break;
                        }
                    ?>  
                </td>
                <td>
                    <?  
                        $year = substr( $maintenance['yearmonth'] ,0 ,4 );
                        echo $year
                    ?>
                </td>                 
                <td><?=$maintenance['job_address_number']?> <?=ucFirst($maintenance['job_address'])?> <?=ucFirst($maintenance['job_suburb'])?>  </td>
                <td><?
                        if($maintenance['is_printed'] >= 1)
                        {
                            ?>
                            Signed
                        <?
                        }
                        else
                        { ?>
                            <a href="<?=URL?>/maintenance/form/<?=$maintenance['maintenance_id']?>">View/Update</a>          
                        <? }?>
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
                    /*[0, "asc"]*/
                ],
                columnDefs: [
       { type: 'date-uk', targets: 0 }
     ],
                paging: false,
                searching: true,

            });
        });
    </script>

