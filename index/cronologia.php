<?php
if(!file_exists("html/cronologia.html") ||
	!file_exists("funLog.php") ||
	!file_exists("decodifica.php") ||
	!file_exists("connection_db.php") )
{ header("Location:404.php"); exit;}
include_once "decodifica.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
$us = $_SESSION['Email'];
$usl = $_SESSION['Nome'];
if(empty($us) || empty($usl)){ header('Location:login.php');exit; }
$p = filter_input(INPUT_GET, 'pag' , FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(!is_numeric($p) || !isset($p)) $p = 1;
global $conn;
$tasso = 5;
$rig = numFatt($conn , $us);
if($p > 1){ $ini = ($rig - (($p - 1) * 5) ); }
else { $ini = $rig; }
$fin = ($p - 1) * $tasso;
if(!$result = $conn->query("select * from Fattura join OrdineConcluso on Fattura.ID=Fattura where Intestatario='$us' ORDER BY OrdineConcluso.Id DESC LIMIT $fin , $tasso"))
		{ header('Location:404.php');exit; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/cronologia.html');
$xpath = new DOMXpath($doc);
if(!empty($usl)){ $xpath->query("//*[@id='pulsanteA']")->item(0)->nodeValue = $usl; }
$ok = true;
$n = $result->num_rows;
if($n <= 0){
	$ok = false;
	$x = $xpath->query("//*[@class='intestW']")->item(0);
	$x->removeChild($x->firstChild);
	$x->removeChild($x->firstChild);
	$x->appendChild($doc->createElement('h1' , 'Nessun ordine presente!'));
	$x = $xpath->query("//*[@class='boxW']")->item(0);
	$x->appendChild($doc->createElement('p' , 'Una volta effettuati degli ordini, qui puoi controllare la tua cronologia'));
	$x->appendChild($doc->createElement('p' , 'Acquista i nostri prodotti dalla nostra <a href="index.php"><span xml:lang="en">Home page</span></a>'));
 }
else{
$numOrd = $ini;
$numOrd++;
while($row = $result->fetch_array(MYSQLI_ASSOC)){
$id = $row['Fattura'];
$out = lista($row , $id , $conn);
$tmp = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement('fieldset' , '
  <legend>Ordine N°: ' . ($numOrd - 1) . '</legend><ul class="listInfo"><li><span>Data: </span>' . $row["Data"] . '</li>
    <li><span>Tipo di Spedizione: </span>' . $row["Spedizione"] . '</li>
    <li class="line"><span>Prodotti:	</span>
	<ul class="listProd">
' . $out . '</ul></li><li class="tot">Costo Totale : ' . $row['CostoFinale'] . ' €</li></ul>')); 
$tmp->setAttribute('class' , 'riquadro');
	$numOrd--; }
$numPag = intdiv($rig , $tasso);
if(($rig % $tasso) > 0)
	$numPag++;
$aux = $p - 1;
$y = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement("div" , ""));
$y->setAttribute('class' , 'paging');
$y->appendChild($doc->createElement("span" , "Vai alla pagina:"));
$z = $y->appendChild($doc->createElement("ul" , ""));
if($p > 1)
         $z->appendChild($doc->createElement("li" , "&lt;a href='?pag=$aux'&gt;Pagina precedente&lt;/a&gt;"));
        for($i = 1; $i <= $numPag; $i++){
                if($p == $i) { $active = $z->appendChild($doc->createElement("li" , "&lt;a&gt;" . $i . "&lt;/a&gt;")); $active->setAttribute('class' , 'active'); }
                else $z->appendChild($doc->createElement("li" , "&lt;a href='?pag=$i'&gt;" . $i . "&lt;/a&gt;")); }
$aux = $p + 1;
if($aux <= $numPag)
        $z->appendChild($doc->createElement("li" ,"&lt;a href='?pag=$aux'&gt;Pagina successiva&lt;/a&gt;")); }
print decod($doc->saveXML());
$result->free();
$conn->close();

function lista($row , $id , $conn){
	$out = '';
if(!$result2 = $conn->query("SELECT * FROM DettaglioFattura JOIN Prodotto ON Prodotto=Codice WHERE Fattura=$id"))
			{ header('Location:404.php');exit; }
while($row && $row2 = $result2->fetch_array(MYSQLI_ASSOC)){
	$lingua = '';
	if(strcmp($row2['Lingua'] , 'it') !== 0) { $lingua = "xml:lang='" . $row2['Lingua'] . "'"; }
 $out .= '<li><span ' . $lingua . '>' . $row2['Nome'] . '</span><span>Quantità: ' . $row2["Quantita"] . '</span><span>Prezzo: ' . $row2['Costo'] . '€</span></li>'; }
return $out; }
function numFatt($conn , $us){
global $conn;
if($result = $conn->prepare("SELECT COUNT(*) FROM Fattura JOIN OrdineConcluso ON Fattura.ID=Fattura WHERE Intestatario='$us'")){
        if($result->execute()){
        $result->bind_result($ris);
        $result->fetch();
        $result->close();
        return $ris; }
}
$conn->close();
return -1;
}
?>
