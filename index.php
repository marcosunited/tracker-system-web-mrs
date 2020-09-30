<?php
    //Load Element config and Framework
    include('config.php');
    
    //Load the folders
    loadDir('/models/');
    loadDir('/views/');
    loadDir('/controllers/');    
    loadDir('/functions/');
	
    //Get Er Rolling
    session_init(); 
?>
