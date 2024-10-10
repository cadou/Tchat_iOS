<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>
    Vie</title>

<style media="screen">
  * {
    padding: 0;
    margin:0;
    box-sizing: content-box;
    color: black;
    text-decoration: none;
  }

div {
  display: block;  overflow: hidden;
  width:200px;
  height: 35px;
  border: 1px solid black;
  margin: 15px;
}

div aside {
  height: inherit;
  width: 0%;
  background-color: red;
}

</style>


</head>

<body>

<div class="barre">
<aside id="vie"></aside>
</div>

<button type="button" name="button" onclick="console.log(unique(8,[32]))">%</button>

<script>


  function unique(a, except) {
    if (arguments.length == 1) {
      except = [];
    }
    var arr = [];
    var r = Math.floor(Math.random() * a) + 1;
    while (arr.length < a - except.length) {
      r = Math.floor(Math.random() * a) + 1;
      if (arr.indexOf(r) == -1 && except.indexOf(r) == -1) {
        arr.push(r);
      }
    }
    return arr;
  }


function attaquer(pourcent) {


var pourcent_actuel = parseInt(window.getComputedStyle(document.getElementById("vie"), null).getPropertyValue("width")) / 2;
document.getElementById("vie").style.width = (pourcent_actuel + pourcent) + "%";
if((pourcent_actuel + pourcent) == 100)
  {
    alert("Game Over");
  }
return pourcent_actuel + pourcent;
//console.log(document.getElementById("vie").offsetWidth)


}


</script>

</body>

</html>
