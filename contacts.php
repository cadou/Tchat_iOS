<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Contacts</title>
    <link rel="stylesheet" href="/main.css">


<style>
  a {
  	margin: 0;
  }

  ul {
    margin: 0px 50px;
    display: block;
    list-style: none;
  }

  ul li {
    padding: 0 10px 10px 10px;
  }

  ul li p {
    padding: 8px 0;
  }


  </style>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
<header>
  <button type="button" onclick="window.location.href='all_contacts.php'" name="button">+</button>
  <?php   session_start(); print_r($_SESSION); echo "<br>".$_SESSION["login_connected"]." est connecté."; ?>
</header>


<main>
  <ul>


  <?php

  include_once("db.php");
  $DB = new DB("tchat");

$results = $DB->storedProcedure("list_contacts",array(json_decode($_SESSION["id"])))->RESPONSE;




foreach($results as $usr)
                {
                  $last_message = $DB->storedProcedure("last_message",array($usr->ID_USR, json_decode($_SESSION["id"])))->RESPONSE;
if(!empty($last_message[0]->CONTENU_MSG)) {
                    echo "<li><a href='bubble.php?usr_rv=".$usr->ID_USR."'>".$usr->PSEUDO_USR."  :  ".$last_message[0]->MSG_DTHR."
                    </a><p>".$last_message[0]->CONTENU_MSG."</p></li>";
                    }
                }

  ?>
  </ul>
</main>
<footer></footer>

</body>

</html>
