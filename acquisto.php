<?php
if(!file_exists("html/acquisto.html") ||
	!file_exists("filtro.php") ||
	!file_exists("funLog.php") ||
	!file_exists("decodifica.php") ||
	!file_exists("connection_db.php") )
{ header("Location:404.php"); exit;}
include_once "filtro.php";
include_once "decodifica.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
$us = $_SESSION['Email'];
$usl = $_SESSION['Nome'];
if(empty($us) || empty($usl)){ header('Location:login.php');exit; }
global $conn;
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/acquisto.html');
$xpath = new DOMXpath($doc);
$xpath->query("//*[@accesskey='a']")->item(0)->nodeValue = $usl;
	if(!$result = $conn->query("SELECT * FROM Carrello JOIN OrdineInCorso ON OrdineInCorso=ID JOIN Prodotto ON Prodotto=Codice WHERE Cliente='$us'"))
		{ header("Location:404.php"); exit; }
if($result->num_rows >= 1){
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$prz = $row['PrezzoProdotti'];
		if(strcmp($row['Lingua'] , 'it') !== 0)
			{ $x = $xpath->query("//*[@id='elencoProd']")->item(0)->appendChild($doc->createElement('li' , $row['Nome'] . ' , quantità : ' . $row['Quantita']));
				$x->setAttribute('xml:lang' , $row['Lingua']); }
		else { $xpath->query("//*[@id='elencoProd']")->item(0)->appendChild($doc->createElement('li' , $row['Nome'] . ' , quantità :  ' . $row['Quantita'])); }}
$xpath->query("//*[@class='subt']")->item(0)->nodeValue = $prz . "€"; }
else { $result->close();$conn->close();header('Location:carrello.php');exit; }
print decod($doc->saveXML());
$result->free();
$conn->close();
?>
