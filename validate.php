
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
    font-family: "Arial";
    font-size: 11pt;
  }

span[contenteditable="true"],span[contenteditable="false"]
 {
    border: 1px solid #b0b0b0;
    margin: 40px;
  height:auto;
    border-radius: 8px;
  padding:4px 8px;
  display: inline-block;
  width: calc(100vw - 96px);
}


  *:focus{
    outline: 0;
  }

  span[contenteditable="false"] {
    border: none;
}



</style>


</head>

<body>


<span role="textbox" id="test" name="test">&#8205;</span>
<span role="textbox" id="test1" name="test1">&#8205;</span>

<script>





  let elements = document.querySelectorAll("*");



  elements.forEach((e) => {
    if (e.tagName == "SPAN")
    {


let nb = 0;
e.setAttribute("contenteditable","true");

e.addEventListener('paste', function (event) {
  event.preventDefault();
  document.execCommand('inserttext', false, event.clipboardData.getData('text/plain').trim());
});

e.addEventListener('copy', function (event) {
  event.preventDefault();
  document.execCommand('inserttext', false, event.clipboardData.getData('text/plain').trim());
});


Object.defineProperty(e, 'length', {
    get: function() {
        return this.textContent.length - 1;
    }
});

function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

e.text = function() {
  return this.textContent;
}

e.oninput = function()
{

  if (this.innerHTML.length < 1)
    {
      this.innerHTML = "&#8205;";
      placeCaretAtEnd(this);
    }
}
}
   }
 )



</script>

</body>

</html>
