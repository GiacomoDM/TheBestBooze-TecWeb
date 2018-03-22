<?php
if(!file_exists("html/accountAm.html") ||
        !file_exists("addProd.php") ||
        !file_exists("funLog.php") ||
        !file_exists("listaProd.php") ||
        !file_exists("decodifica.php")){ header('Location:404.php');exit; }
include_once'decodifica.php';
include_once"funLog.php";
inizio();
                rigeneraId(false,false,false,false);
                if(empty($_SESSION['Admin']))
                        { header('Location:loginAm.php');exit; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML(file_get_contents('html/accountAm.html'));
print decod($doc->saveXML());
?>
