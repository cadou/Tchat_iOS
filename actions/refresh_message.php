<?php
session_start();
include_once("../db.php");
$DB = new DB("tchat");


$discussion = $DB->storedProcedure("list_messages",array($_SESSION["usr_rv"], json_decode($_SESSION["id"])));

foreach($discussion->RESPONSE as $message)
{
  $class = ((intval($message->ID_USR) == intval(json_decode($_SESSION["id"])))?"bubble bubble--alt":"bubble");
echo "<li class=\"".$class."\"><h6>".$message->MSG_DTHR."</h6>".$message->CONTENU_MSG."</li>";
}

 ?>
