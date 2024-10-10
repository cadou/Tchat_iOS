<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>
    Les oiseaux</title>

<style media="screen">
  * {
    padding: 0;
    margin:0;
    box-sizing: content-box;
    color: black;
    text-decoration: none;
  }


</style>


<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
<input type="text" id="login" name="login" value="cadou">
<input type="text" id="mdp" name="mdp" value="azerty">
<button onclick="save()">VALIDER</button>


<script src="ajax.js" charset="utf-8"></script>
<script>

  function save() {

      var login = document.getElementById("login");
var mdp = document.getElementById("mdp");

        document.AJAX.sendRequest("actions/connect.php", {
          login: login.value,
          mdp: mdp.value
        }, function(response) {
          console.log(response)
          if (parseInt(response.trim()) != 0) {
window.location.href = "contacts.php";
          }
        });

    }


</script>

</body>

</html>
