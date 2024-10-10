<?php
header('Content-Type: application/json; charset=utf-8');
include_once("../db.php");
$DB = new DB("tchat");




$login = $DB->storedFunction("checkLogin",array($_POST["login"]));

$result = json_encode($login->RESPONSE);

if (!empty($result))
{
session_start();
  $_SESSION["id"] = $result;
    $_SESSION["login_connected"] = $_POST["login"];
}
?>
