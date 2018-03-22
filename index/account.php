<?php
if(!file_exists("html/account.html") ||
        !file_exists("modificaDati.php") ||
        !file_exists("info.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("funLog.php") ||
        !file_exists("cronologia.php") ||
        !file_exists("faq.php") ||
        !file_exists("elimina.php")){ header('Location:404.php');exit; }
                include_once"decodifica.php";
                include_once"funLog.php";
inizio();
rigeneraId(false,false,false,false);
$us = "";
if(!empty($_SESSION['Nome']))
        $us = $_SESSION['Nome'];
if($us && !empty($_SESSION['Email'])){
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/account.html');
$xpath = new DOMXpath($doc);
$xpath->query("//*[@id='pulsanteA']")->item(0)->nodeValue = $us;
print decod($doc->saveXML()); }
else { header('Location:login.php');exit; }
?>

