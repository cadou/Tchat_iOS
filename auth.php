<<<<<<< HEAD
<?php

function is_connected():bool {
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION["connected"]);
}


if(!is_connected())
 {
   header('Location:index.php');
   exit;
 }



 ?>
=======
<?php

function is_connected():bool {
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    return !empty($_SESSION["connected"]);
}


if(!is_connected())
 {
   header('Location:index.php');
   exit;
 }



 ?>
>>>>>>> abe5629a644b021a00fb3bd581678f9071f18a07
