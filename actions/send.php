<<<<<<< HEAD
<?php
session_start();
include_once("../db.php");
$DB = new DB("tchat");

echo  $DB->storedProcedure("send_message",array("",$_POST["message"],json_decode($_SESSION["id"]),$_SESSION["usr_rv"]))->SUCCESS;


 ?>
=======
<?php
session_start();
include_once("../db.php");
$DB = new DB("tchat");

echo  $DB->storedProcedure("send_message",array("",$_POST["message"],json_decode($_SESSION["id"]),$_SESSION["usr_rv"]))->SUCCESS;


 ?>
>>>>>>> abe5629a644b021a00fb3bd581678f9071f18a07
