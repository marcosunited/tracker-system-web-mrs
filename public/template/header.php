<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">

        <title><?=APPNAME?></title>
        <link rel="icon" type="image/png" href="<?=URL?>/public/img/uls.png">

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        
        <script src="<?=URL?>/public/skeletor-foundation/js/jquery-3.1.0.min.js"></script>
        <script src="<?=URL?>/public/skeletor-foundation/plugins/multimenu/modernizr-custom.js"></script>
        <script src="<?=URL?>/public/skeletor-foundation/js/skeletor.js"></script>  
        <script src="<?=URL?>/public/js/element.js"></script>
        <script src="<?=URL?>/public/skeletor-foundation/plugins/multimenu/multimenu.js"></script>  
        <script src="<?=URL?>/public/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=URL?>/public/js/jquery-timepicker/dist/jquery-ui-timepicker-addon.min.js"></script>
        <script src="<?=URL?>/public/js/jsignature/jSignature.min.js"></script>
        <script src="<?=URL?>/public/js/maintenanceFormData.js"></script>
        
        <link rel="stylesheet" href="<?=URL?>/public/skeletor-foundation/css/fonts.css">
        <link rel="stylesheet" href="<?=URL?>/public/skeletor-foundation/css/normalize.css">
        <link rel="stylesheet" href="<?=URL?>/public/skeletor-foundation/css/skeleton.css">
        <link rel="stylesheet" href="<?=URL?>/public/skeletor-foundation/css/skeletor.css">
        <link rel="stylesheet" href="<?=URL?>/public/skeletor-foundation/plugins/multimenu/multimenu.css">

        <link rel="stylesheet" href="<?=URL?>/public/js/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?=URL?>/public/js/jquery-timepicker/dist/jquery-ui-timepicker-addon.min.css">

        <script>
            function showPosition(position) {
                $loadString = "<?=URL?>/gps_tracker/index/?user_id=<?=sess("user_id")?>&lat="+position.coords.latitude+"&long="+position.coords.longitude;
                $.get($loadString,function(data){
                    //alert("location Sent: "+$loadString);
                });        
            }        
        </script>
        <? if(sess("alert")) {?>
            <script>
                    $(document).ready(function(){
                            showAlert();
                    });
            </script>
        <?}?>
   
    </head>
    <body>
        <div class="midnight"></div>
        <div class="alert"><?=sess('alert')?></div>
        <?sess('alert','')?>       
        <div class="container">
            <div class="row">
                <div class="left" style="min-width:320px;overflow:hidden">
                    <a href="<?=URL?>" class="skeletor-title">
                        <img src="<?=URL?>/public/img/uls.png" class="logo left">
                        <h5 class="title"><?=APPNAME?></h5>
                    </a>
                </div>
                <div class="multimenu">
                    <div class="multimenu-title">Menu</div>
                    <ul>
                        <? multimenu();?>
                    </ul>
                </div>
            </div>            
            <div class="row">
                <img class="responsive" src="<?=URL?>/public/skeletor-foundation/img/banner.jpg">
            </div>