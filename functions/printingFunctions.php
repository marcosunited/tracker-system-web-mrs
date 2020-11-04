<?
function sendPrinting($filename, $title)
{
    require_once 'public/cloudprint/Config.php';
    require_once 'public/cloudprint/GoogleCloudPrint.php';

    $gcp = new GoogleCloudPrint();

    // Replace token you got in offlineToken.php
    $refreshTokenConfig['refresh_token'] = "1//0eYFKLUcMw6RaCgYIARAAGA4SNwF-L9Ir0u-uESO2vQDphPbsq21Sc1TwJdIOS-JhxJUeGJwk7R1nvrS9pGXYuoQ_yrCCmJOtbnQ";

    $token = $gcp->getAccessTokenByRefreshToken($urlconfig['refreshtoken_url'], http_build_query($refreshTokenConfig));

    $gcp->setAuthToken($token);

    $printers = $gcp->getPrinters();

    $printerid = "3e05bcb9-e61b-5ff1-0383-664ffa9b1cc5";
    if (count($printers) == 0) {
        echo "Could not get printers";
        exit;
    } else {
        //$printerid = $printers[1]['id']; // Pass id of any printer to be used for print
        // Send document to the printer
        $resarray = $gcp->sendPrintToPrinter($printerid, $title, "functions/pdfReports/$filename.pdf", "application/pdf");

        if ($resarray['status'] == true) {
            echo "Document has been sent to printer and should print shortly.";
        } else {
            echo "An error occured while printing the doc. Error code:" . $resarray['errorcode'] . " Message:" . $resarray['errormessage'];
        }
    }
}
?>
