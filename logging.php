<?php   session_start();

$url = "index.php";
if ($_GET["type"] =="login" ) {
    $url = "login.php";
}

if ($_GET["type"] =="logout" ) {
    session_destroy();
}


header( "Location: $url" );
?>