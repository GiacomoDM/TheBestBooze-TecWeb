<?php
if(!file_exists("html/iscrizioneSuccesso.html"))
        { header('Location:404.php');exit; }
else echo file_get_contents("html/iscrizioneSuccesso.html");
?>
