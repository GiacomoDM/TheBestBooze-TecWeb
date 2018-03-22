<?php
if(!file_exists("html/elimina.html") ||
        !file_exists("eliminaAcc.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("funLog.php")){ header('Location:404.php');exit; }
                include_once"decodifica.php";
                include_once"funLog.php";
inizio();
rigeneraId(false,false,false,false);
$user = "";
if(!empty($_SESSION['Nome']))
        $user = $_SESSION['Nome'];
if($user && !empty($_SESSION['Email'])){
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/elimina.html');
$xpath = new DOMXpath($doc);
$xpath->query("//*[@id='pulsanteA']")->item(0)->nodeValue = $user;
print decod($doc->saveXML()); }
else { header('Location:login.php');exit; }
?>
