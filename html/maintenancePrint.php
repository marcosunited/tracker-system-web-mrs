<?ob_start();?>
<html>
  <style>
    a {
      color: #0087C3;
      text-decoration: none;
    }

    body {
      position: relative;
      margin: 0 auto;
      color: #555555;
      background: #FFFFFF;
      font-family: sans-serif;
      font-size: 12px;
      font-family: SourceSansPro;      
    }

    header {
      padding: 10px 0;
      margin-bottom: 20px;
      border-bottom: 1px solid #AAAAAA;
    }

    #logo {
      float: left;
    }

    #logo img {
      margin-top: 8px;
      float: left;
    }

    #company {
      text-align: right;
      margin-right: 80px;
      margin-top: 8px;
    }


    #details {
      margin-bottom: 50px;
    }

    #client {
      padding-left: 6px;
      border-left: 6px solid #0087C3;
      float: left;
    }

    #client .to {
      color: #777777;
    }

    h2.name {
      font-size: 1.4em;
      font-weight: normal;
      margin: 0;
    }

    #invoice {
      padding-right: 6px;
      text-align: right;
      margin-right: 80px;
    }

    #invoice h1 {
      color: #0087C3;
      font-size: 2.4em;
      line-height: 1em;
      font-weight: normal;
      margin: 0 0 10px 0;
    }

    #invoice .date {
      font-size: 1.1em;
      color: #777777;
    }

    #line {
      height: 1px;
      width: 100%;
      background-color: #0087C3;
      margin-bottom: 10px;
      position: absolute;
      bottom: 10px
    }

    serviceTechnician {
      position: absolute;
      bottom: 35px;
    }

    fotter {
      position: absolute;
      bottom: 19px;
    }
  </style>
    <body>
    <header class="clearfix">
      <div id="logo">
        <? $fileLogo = $_SERVER['DOCUMENT_ROOT']."/melbournemrs/public/img/logo.png";?>
        <img src= <?=$fileLogo?> >
      </div>
      <div id="company">
        <div>Unit 3 / 260 Hyde St YARRAVILLE VIC 3013
        </div>
        <div>(03) 9687 9099</div>
        <div>
          info@unitedlifts.com.au
        </div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to"><b style="color:#0087C3">CUSTOMER DETAILS:</b></div>
          <h2 class="name">
            <?=$jobs->model->job_name?>
          </h2>
          <div class="address">
            <?=$jobs->model->job_address_number?>
              <?=$jobs->model->job_address?>
                <?=$jobs->model->job_suburb?>
          </div>
          <div class="email">
            Contract No: <?=$jobs->model->job_number?>
          </div>
        </div>
        <div id="invoice">
          <h1>Maintenance#:
            <?=$this->model->docket_no?>
          </h1>
          <div class="date">Date of Call:
            <?=date(toDate($this->model->maintenance_date))?>
              </p>
          </div>
          <div class="date">Time of Arrival:
            <?=toTime($this->model->maintenance_toa)?>
              </p>
          </div>
          <div class="date">Time of Departure:
            <?=toTime($this->model->maintenance_tod)?>
              </p>
          </div>
        </div>
        <div id ="table">
                
            <div style="border:0px solid black;height:2px;padding:10px;">             
                <b style="color:#0087C3"> <u>Maintenance Details</u></b>
                <br/>
                <b>Maintenance Description: </b>
                <?=$this->model->maintenance_notes?>
             
              <? foreach($this->model->list as $maintenance)
                 {
                    if( $maintenance['lift_id'] < 0 || $maintenance['lift_id'] == null ) 
                        continue; // signed ones no need tp print
                   else 
                   {?>
                    <table width="50%" border="1" style="border-collapse:collapse">
                      <tr>
                        <th>Lift Number </th>                  
                        <th> <?=$maintenance['lift_name'] ?></th>                    
                      </tr>
                      <?} 
                        $tasks = trim($maintenance['task_ids'] ,"|");
                        $tasks = explode("|",$tasks);
                    
                        foreach($tasks as $task)
                        {
                          if( $task == "") continue;
                          if( $maintenance['lift_type'] == "L" )
                              $task_name = get_query("select * from _lift_tasks where task_id =".$task);
                          else 
                              $task_name = get_query("select * from _escalator_tasks where task_id =".$task);                      
                            
                            $task_name = $task_name[0]?>
                              <tr>
                                <td nowrap><?=$task_name["task_name"]?></td>
                                <td> Y </td>
                              </tr>
                       <?}?>
                </table>
              <br>                  
              <?}?>
        </div>

        
      </div>
     
    </main>

    <serviceTechnician>
     <table class = "serviceTechnician">
       <tr>
        <td style="width:300px">          
          <b>Service Technician</b>
          <?=$user["realname"]?>
        </td>
        <td style="width:300px">
          <b>Customer Email</b>          
          <?=$jobs->model->job_email?>
        </td>
      </tr>
     </table>
     </serviceTechnician>

     <div id="line"></div>
    
    <fotter>
      Thank you for choosing  United Lift Services 24 Hour Service, Phone (03) 9687 9099 
    </fotter>
  </body>

  </html>
  <?
	$contents = ob_get_contents();
	ob_end_clean();
    
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';

Dompdf\Autoloader::register();

use Dompdf\Dompdf;



$dompdf = new Dompdf();
  $dompdf->load_html($contents);
  //$customPaper = array(0,0,950,950);
  $dompdf->set_paper('A4', 'portrait');
	$dompdf->render();
  $file_location = $_SERVER['DOCUMENT_ROOT']."/melbournemrs/functions/pdfReports/".$fileName.".pdf";
  file_put_contents($file_location, $dompdf->output());
  //header('Location: ' . $_SERVER['HTTP_REFERER']);
  
?>