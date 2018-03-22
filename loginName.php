<?php
if(!file_exists("decodifica.php") )
{ header("Location:404.php"); exit;}
include_once "decodifica.php";
function loginName($out , $user , $admin){
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($out);
$xpath = new DOMXpath($doc);
$xpath->query("//*[@accesskey='a']")->item(0)->setAttribute('title' , 'Accedi alla tua area personale');
$xpath->query("//*[@accesskey='a']")->item(0)->nodeValue = $user;
$xpath->query("//*[@accesskey='a']")->item(0)->setAttribute('id' , 'pulsanteA');
$xpath->query("//*[@accesskey='a']")->item(0)->removeAttribute('accesskey');
$x = $xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('id' , 'areapers');
if(!$admin){
	$xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('href' , 'account.php');
	$xpath->query("//*[@accesskey='k']")->item(0)->setAttribute('href' , 'carrello.php'); }
else{
	$xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('href' , 'accountAm.php');
	$xpath->query("//*[@accesskey='k']")->item(0)->setAttribute('href' , ''); }
$x = $xpath->query("//*[@id='areapers']")->item(0)->appendChild($doc->createElement('div' , '<form action="logout.php" method="post">
                <fieldset><input type="submit" class="pulsanti" name="esci" value="Log-out" accesskey="o"/></fieldset></form>'));
$x->setAttribute('id' , 'comparsa');
print decod($doc->saveXML()); } 
?>
