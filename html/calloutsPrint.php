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
      width: 21cm;
      height: 29.7cm;
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
        <h2 class="name"></h2>
        <div>Unit 3 / 260 Hyde St YARRAVILLE VIC 3013
        </div>
        <div>03 9687 9099</div>
        <div>
          info@unitedlifts.com.au
        </div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Service Address:</div>
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
            </a>
          </div>
        </div>
        <div id="invoice">
          <h1>Callouts:
            <?=$callout_id?>
          </h1>
          <div class="date">Date of Call:
            <?=toDate($this->model->callout_time)?>
            <?=toTime($this->model->callout_time)?>
          </div>
          <div class="date">Time of Arrival:
		    <?=toDate($this->model->time_of_arrival)?>
            <?=toTime($this->model->time_of_arrival)?>
          </div>
          <div class="date">Rectification Time:
		    <?=toDate($this->model->rectification_time)?>
            <?=toTime($this->model->rectification_time)?>
          </div>
          <div class="date">Time of Departure:
		  <?=toDate($this->model->time_of_departure)?>
            <?=toTime($this->model->time_of_departure)?>
          </div>
        </div>
      </div>
      <table>
        <tr>
          <td colspan="2">
            <div style="border:0px solid black;height:300px;padding:-10px;">
              <p>
                <b style="color:#0087C3">
                  <u>CALLOUTS DETAILS</u>
                </b>
              </p>

              <p>
                <b>Reported Fault (COMPLAINT): </b>
                <?=$faults->model->fault_name?>
              </p>
              <p>
                <b>For Lift(s): </b>
                <?=liftNames($this->model->lift_ids)?>
              </p>
			  
			 <b>For Floor(s):</b>
                <?=$this->model->floor_no?>
              </p>

              <p>
                <b>Call Description:</b>
                <?=$this->model->callout_description?>
              </p>
			  
			  <b>Order Number:</b>
                <?=$this->model->order_number?>
              </p>

              <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;"></div>

              <p>
                <b style="color:#0087C3">
                  <u>DESCRIPTION OF WORK</u>
				  
                </b>
              </p>
              <p>
                <b>Fault Found (CAUSE):</b>
                <?=$technician_faults->model->technician_fault_name?>
              </p>
              <p>
                <b>Work Action (CORRECTION):</b>
                <?=$correction->model->correction_name?>
              </p>
              <p>
                <b>Work Description:</b>
                
                <?=$this->model->tech_description?>
              </p>
              <p>
                <b>Part Required:</b>
                
                <?=$this->model->part_description?>
              </p>
            </div>
          </td>
        </tr>
      </table>
      <table style="margin-top:80px;">
        <tr>
          <td style="width:300px">
            <p>
              <b>Service Technician</b>
            </p>
            <?=$user["realname"]?>
          </td>
          <td style="width:300px">
            <p>
              <b>Report Customer</b>
            </p>
            <?=$this->model->reported_customer?>
          </td>
        </tr>
      </table>
    </main>
    <div id="line"></div>
    <fotter>
      Thanks for choosing United Lifts Services! 24 Hour Service, Phone 1300161740
    </fotter>
  </body>

  </html>
  <?
	$contents = ob_get_contents();
	ob_end_clean();
  /*  
	require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->load_html($contents);
	$dompdf->render();
    $file_location = $_SERVER['DOCUMENT_ROOT']."/melbournemrs/functions/pdfReports/".$this->model->callout_time.".pdf";
    file_put_contents($file_location, $dompdf->output());
    header('Location: ' . $_SERVER['HTTP_REFERER']); */

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
      $file_location = $_SERVER['DOCUMENT_ROOT']."/melbournemrs/functions/pdfReports/".$this->model->callout_time.".pdf";
      file_put_contents($file_location, $dompdf->output());
    
?>
