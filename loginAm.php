<?php
if(!file_exists("html/loginAm.html"))
        { header('Location:404.php');exit; }
else echo file_get_contents("html/loginAm.html");
?>
