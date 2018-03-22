<?php
if(!file_exists("html/login.html"))
        { header('Location:404.php');exit; }
else echo file_get_contents("html/login.html");
?>
