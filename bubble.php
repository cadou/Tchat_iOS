<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title><?php   session_start(); echo $_SESSION["login_connected"]; ?></title>
    <link rel="stylesheet" href="/main.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

<header>
  <button type="button" onclick="window.location.href='contacts.php'" name="button">Back</button>
  <?php
  include_once("db.php");
  setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
  $DB = new DB("tchat");
  $_SESSION["usr_rv"] = $_GET["usr_rv"];
  $whoIs = $DB->storedFunction("receiver_name",array($_SESSION["usr_rv"]));

  echo $_SESSION["login_connected"]." > ".$whoIs->RESPONSE;
   ?>
</header>


<main>
  <ul class="discussion" id="discussion">

    <?php








    $discussion = $DB->storedProcedure("list_messages",array($_SESSION["usr_rv"], json_decode($_SESSION["id"])));

  foreach($discussion->RESPONSE as $message)
    {
      $class = ((intval($message->ID_USR) == intval(json_decode($_SESSION["id"])))?"bubble bubble--alt":"bubble");
echo "<li class=\"".$class."\"><h6>".$message->MSG_DTHR."</h6>".$message->CONTENU_MSG."</li>";
    }


     ?>
   </ul>
</main>
  <footer>
    <textarea name="name" id="message"></textarea>
    <button id="send" onclick="send()">Envoyer</button>
  </footer>

  <script src="ajax.js" charset="utf-8"></script>
  <script>

    function send() {

        var message = document.getElementById("message");

          document.AJAX.sendRequest("actions/send.php", {
            message: message.value
          }, function(response) {
            console.log(response)

if(response == "true")
{
  window.location.reload();
}

          });

      }


      const interval = setInterval(function() {
        document.AJAX.sendRequest("actions/refresh_message.php", {},
          function(response)
          {
            console.log(response);
            document.getElementById("discussion").innerHTML = response;
      });
       }, 1000);


       var input = document.getElementById("message");
       input.addEventListener("keypress", function(event) {
         if (event.key === "Enter") {
           event.preventDefault();
           document.getElementById("send").click();
           input.focus();
         }
       });



  </script>


</body>

</html>
