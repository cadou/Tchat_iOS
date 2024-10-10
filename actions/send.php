<?php
session_start();
include_once("../db.php");
$DB = new DB("tchat");

echo  $DB->storedProcedure("send_message",array("",$_POST["message"],json_decode($_SESSION["id"]),$_SESSION["usr_rv"]))->SUCCESS;


 ?>
