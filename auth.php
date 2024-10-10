<?php

function is_connected():bool {
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION["connected"]);
}


if(!is_connected())
 {
   header('Location:index.php');
   exit;
 }



 ?>
