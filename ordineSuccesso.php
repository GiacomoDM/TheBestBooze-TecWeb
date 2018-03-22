<?php
if(!file_exists("html/ordineSuccesso.html"))
{ header('Location:404.php');exit; }
echo file_get_contents('html/ordineSuccesso.html');
 ?>
