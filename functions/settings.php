
<?php

function getSettings(){
    $settingsQuery = "SELECT * FROM SETTINGS";
    $settingsQueryResponse = db::query($settingsQuery);

}
