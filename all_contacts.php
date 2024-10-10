<<<<<<< HEAD
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Contacts</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="/main.css">



</head>

<body>
  <header>
    <button type="button" onclick="window.location.href='contacts.php'" name="button">Back</button>
    <?php   session_start(); echo "<br>".$_SESSION["login_connected"]." est connecté."; ?>
    <button type="button" onclick="window.location.href='index.php'" name="button">Disconnect</button>
  </header>
  <main>
<?php
  include_once("db.php");
  $DB = new DB("tchat");

$results = $DB->storedProcedure("all_contacts",array(json_decode($_SESSION["id"])))->RESPONSE;





foreach($results as $usr)
                {
                    echo "<a href='bubble.php?usr_rv=".$usr->ID_USR."'>".$usr->PSEUDO_USR."</a>";
                }

  ?>
</main>
<footer>
  Sauf le mien !
</footer>

</body>

</html>
=======
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Contacts</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="/main.css">



</head>

<body>
  <header>
    <button type="button" onclick="window.location.href='contacts.php'" name="button">Back</button>
    <?php   session_start(); echo "<br>".$_SESSION["login_connected"]." est connecté."; ?>
    <button type="button" onclick="window.location.href='index.php'" name="button">Disconnect</button>
  </header>
  <main>
<?php
  include_once("db.php");
  $DB = new DB("tchat");

$results = $DB->storedProcedure("all_contacts",array(json_decode($_SESSION["id"])))->RESPONSE;





foreach($results as $usr)
                {
                    echo "<a href='bubble.php?usr_rv=".$usr->ID_USR."'>".$usr->PSEUDO_USR."</a>";
                }

  ?>
</main>
<footer>
  Sauf le mien !
</footer>

</body>

</html>
>>>>>>> abe5629a644b021a00fb3bd581678f9071f18a07
