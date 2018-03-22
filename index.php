<?php
if(!file_exists("html/home.html") ||
	!file_exists("decodifica.php") ||
	!file_exists("funLog.php") ||
	!file_exists("connection_db.php") )
{ header("Location:404.php");exit; }
include_once "connection_db.php";
include_once "decodifica.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
global $conn;
if(!$result = $conn->query("select Prodotto, Nome, Lingua, Prezzo, sum(Quantita) as Q from DettaglioFattura join Prodotto on Prodotto=Codice group by Prodotto order by Q desc limit 4"))
{ $conn->close();header('Location:404.php');exit; }
$fin=file_get_contents("html/home.html");
$usl = "";
if(!empty($_SESSION['Nome']))
        { $usl = $_SESSION['Nome'];$admin = false; }
if(!empty($_SESSION['Admin']))
        { $usl = $_SESSION['Admin'];$admin = true; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/home.html');
$xpath = new DOMXpath($doc);
if(!empty($usl)){
$xpath->query("//*[@accesskey='a']")->item(0)->setAttribute('title' , 'Accedi alla tua area personale');
$xpath->query("//*[@accesskey='a']")->item(0)->nodeValue = $usl;
$xpath->query("//*[@accesskey='a']")->item(0)->setAttribute('id' , 'pulsanteA');
$xpath->query("//*[@accesskey='a']")->item(0)->removeAttribute('accesskey');
$x = $xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('id' , 'areapers');
if(!$admin) { 
	$xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('href' , 'account.php');
	$xpath->query("//*[@accesskey='k']")->item(0)->setAttribute('href' , 'carrello.php'); }
else { 
	$xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('href' , 'accountAm.php');
	$xpath->query("//*[@accesskey='k']")->item(0)->setAttribute('href' , ''); }
$x = $xpath->query("//*[@id='areapers']")->item(0)->appendChild($doc->createElement('div' , '<form action="logout.php" method="post">
                <fieldset><input type="submit" class="pulsanti" name="esci" value="Log-out" accesskey="o"/></fieldset></form>'));
$x->setAttribute('id' , 'comparsa'); }
$lingua = '';
if($result->num_rows >= 1){
$x = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('div' , ''));
$x->setAttribute('id' , 'topsold');
$xpath->query("//*[@id='topsold']")->item(0)->appendChild($doc->createElement('h1' , 'Prodotti più venduti'));
while($row = $result->fetch_array(MYSQLI_ASSOC)){
if(strcmp($row['Lingua'] , 'it') !== 0)
 $lingua = "xml:lang='" . $row['Lingua'] . "'"; 
$x = $xpath->query("//*[@id='topsold']")->item(0)->appendChild($doc->createElement('div' , '
  <a href="prodotto.php?prod=' . $row["Nome"] . '">
    <img src="img/' . str_replace(" ", "", $row["Nome"]) . '.jpg" alt="' . $row["Nome"] . '"/>
    <span class="titolo" ' . $lingua . '>' . $row["Nome"] . '</span>
    <span>Prezzo: ' . $row["Prezzo"] . '€</span>
  </a>')); 
$x->setAttribute('class' , 'prodotto'); }}
print decod($doc->saveXML());
$result->free();
$conn->close();
?>
