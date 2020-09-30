<?    
    /*
        Element Framework - Cody Joyce
        File Updated 23-2-2016
        
        Configuration File
    */    
    
    define('APPNAME','MelbourneMRS',true);   
    define('APPDIR','melbournemrs',true);
    
    //Database Settings
    define('DB_USER','root',true);
    define('DB_PASSWORD','Wdugags1',true);
    define('DB_HOST','localhost',true);
    define('DB_DATABASE','melbournemrs',true);   

    date_default_timezone_set("Australia/Melbourne");
    
    //Error Reporting
    error_reporting(E_ALL);
    ini_set('display_errors', True);
    ini_set('display_startup_errors', False);   

    //Log Errors
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

    include('element.php');
?>
