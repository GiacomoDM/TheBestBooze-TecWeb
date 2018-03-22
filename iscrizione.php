<?php
if(!file_exists("html/iscrizione.html"))
        { header('Location:404.php');exit; }
else echo file_get_contents("html/iscrizione.html");
?>
