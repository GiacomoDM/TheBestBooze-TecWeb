<?php
if(!file_exists("carrello.php") ||
!file_exists("decodifica.php") ||
!file_exists("showErr.php") ||
!file_exists("connection_db.php") ||
!file_exists("funLog.php") ||
!file_exists("filtro.php")) { header('Location:404.php');exit; }
include_once "filtro.php";
include_once "connection_db.php";
include_once "decodifica.php";
include_once "funLog.php";
include_once "showErr.php";
inizio();
rigeneraId(false,false,false,false);
$us = $_SESSION['Email'];
$usl = $_SESSION['Nome'];
$ind = $ncarta = $citta = $ErrCit = $ErrInd = $ErrNumCarta = '';
if(empty($us)){ header("Location:login.php");exit; }
$carta = filter_input(INPUT_POST , 'carta' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$carta = filtroRic($carta);
$mthd = filter_input(INPUT_POST , 'mthd' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$mthd = filtroRic($mthd);
$addr = filter_input(INPUT_POST , 'addr' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$addr = filtroRic($addr);
$sped = filter_input(INPUT_POST , 'sped' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$sped = filtroRic($sped);
$ok = false;
$arr = array("Standard" , "Daily" , "Express");
$arrSped = array("7-10" , "1" , "3-5");
$CostoSped = array(0 , 15 , 5);
global $conn;
        if(!$Result = $conn->query("SELECT * FROM Cliente WHERE Email='$us'") )
                { $conn->close();header("Location:404.php");exit; }
        $row = $Result->fetch_array(MYSQLI_ASSOC);
        $ind = $row['Indirizzo'];
        $citta = $row['Citta'];
        $carta = $row['TipoCarta']; 
        $ncarta = $row['NumeroCarta'];
        $Result->free();
if(strcmp($addr , 'nuovoindirizzo') === 0){
$ind = filter_input(INPUT_POST , 'indirizzo' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$ind = filtroRic($ind);
$citta = filter_input(INPUT_POST , 'citta' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$citta = filtroRic($citta);
if(!$citta || strlen($citta) > 30) $ErrCit = "errore : formato città errata o vuota";
if(!$ind || strlen($ind) > 30) $ErrInd = "errore : formato indirizzo errata o vuota"; }
if(strcmp($mthd , 'nuovometodo') === 0){
$ncarta = filter_input(INPUT_POST , 'Num' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$ncarta = filtroBase($ncarta);
$ncarta = str_replace(' ' , '' , $ncarta);
$dimNcarta = strlen($ncarta);
if(!$ncarta || !ctype_digit($ncarta) || $dimNcarta < 5 || $dimNcarta > 16) $ErrNumCarta = "errore : formato numero carta errato o vuoto"; 
$arr2 = array("Visa" , "AmericanExpress" , "MasterCard");
                for($i = 0; $i < 3 && !$ok; $i++){ (strcmp($arr2[$i] , $carta) === 0) ? $ok = true : $ok = false; }
		if(!$ok)
			{ header("Location:404.php");exit; }
}
if($ErrCit || $ErrInd || $ErrNumCarta){ Errori($ErrInd , $ErrNumCarta , $ErrCit , $ind  , $ncarta , $citta , $usl , $us); }
if(!$result = $conn->query("SELECT * FROM OrdineInCorso WHERE Cliente='$us'"))
{ $conn->close();header("Location:404.php"); exit; }
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $costot = $row['PrezzoProdotti'];
        $d = date('Y-m-d');
        $result->free();
if(!$conn->query("INSERT INTO Fattura (Intestatario, Data, Totale) VALUES ('$us', '$d', '$costot')"))
{ $conn->close();header("Location:404.php");exit; }
$idf = $conn->insert_id;
if(!$result = $conn->query("SELECT * FROM OrdineInCorso JOIN Carrello ON ID = OrdineInCorso WHERE Cliente='$us'"))
{ $conn->close();header("Location:404.php");exit; }
if($result->num_rows < 1){ $conn->close();header("Location:carrello.php");exit; }
while($row = $result->fetch_array(MYSQLI_ASSOC)){
$idprod = $row['Prodotto'];
$quantita = $row['Quantita'];
$costo = $row['Costo'];
$idoic = $row['ID'];
if(!$conn->query("INSERT INTO DettaglioFattura (Fattura, Prodotto, Quantita, Costo) VALUES ('$idf' , '$idprod' , '$quantita' , '$costo')"))
			{ $conn->close();header("Location:404.php");exit; }}
		$ok = false;
		for($i = 0; $i < 3 && !$ok; $i++){ 
			if(strcmp($arr[$i] , $sped) === 0) { 
				$ok = true;
				$gl = $arrSped[$i];
				$costot += $CostoSped[$i]; } 
			else { $ok = false; }}
		if(!$ok)
			{ header("Location:404.php");exit; }
if(!$conn->query("INSERT INTO OrdineConcluso (Fattura, Spedizione, GiorniLavorativi, CostoFinale) VALUES ('$idf', '$sped', '$gl', '$costot')"))
                        { $conn->close();header('Location:404.php');exit; }
if(!$conn->query("DELETE FROM OrdineInCorso WHERE ID=$idoic"))
                        { $conn->close();header("Location:404.php");exit; }
$result->free();
$conn->close();
if(!$ErrCit && !$ErrInd && !$ErrNumCarta){ header("Location:ordineSuccesso.php");exit; }


function Errori($errI , $errN , $errC , $I , $N , $C , $usl , $us){
global $conn;
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/acquisto.html');
$xpath = new DOMXpath($doc);
if($errI || $errC){
$xpath->query("//*[@id='predaddr']")->item(0)->removeAttribute('checked');
$xpath->query("//*[@id='newaddr']")->item(0)->setAttribute('checked' , 'checked');
}
if($I) $xpath->query("//*[@name='indirizzo']")->item(0)->setAttribute('value' , $I); 
if($C) $xpath->query("//*[@name='citta']")->item(0)->setAttribute('value' , $C); 
if($errI) { showErr($errI , $xpath->query("//*[@name='indirizzo']/..") , 'p' , 'class' , 'errin' , $doc); }
if($errN) { 
showErr($errN , $xpath->query("//*[@name='Num']/..") , 'p' , 'class' , 'errin' , $doc);
$xpath->query("//*[@id='predpay']")->item(0)->removeAttribute('checked');
$xpath->query("//*[@id='newpay']")->item(0)->setAttribute('checked' , 'checked');
if($N) $xpath->query("//*[@name='Num']")->item(0)->setAttribute('value' , $N); }
if($errC) { showErr($errC , $xpath->query("//*[@name='citta']/..") , 'p' , 'class' , 'errin' , $doc); }
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
print decod($doc->saveXML());
$result->free();
$conn->close();
exit;
}
?>
