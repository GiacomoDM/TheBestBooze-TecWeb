<?php
if(!file_exists("html/carrello.html") ||
	!file_exists("decodifica.php") ||
	!file_exists("funLog.php") ||
	!file_exists("connection_db.php") )
{ header("Location:404.php"); exit;}
include_once "decodifica.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
global $conn;
if(empty($_SESSION['Email']) || empty($_SESSION['Nome'])){ header('Location:login.php');exit; }
$us = $_SESSION['Email'];
if(!$result = $conn->query("SELECT * FROM Carrello join OrdineInCorso ON OrdineInCorso=ID JOIN Prodotto ON Prodotto=Codice WHERE Cliente='$us'"))
 { header('Location:404.php');exit; }
$usl = $_SESSION['Nome'];
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/carrello.html');
$xpath = new DOMXpath($doc);
if(!empty($usl)){ $xpath->query("//*[@accesskey='a']")->item(0)->nodeValue = $usl; }
if($result->num_rows > 0){
$i = 0 ; $aux = "";
while($row = $result->fetch_array(MYSQLI_ASSOC)){
$aux = $row['ID'];
(strcmp($row['Lingua'] , "it") === 0) ? $lin = "" : $lin = $row["Lingua"];
$x = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement('div' , '<img src=&quot;img/' . str_replace(" " , "" , $row["Nome"]) . '.jpg&quot; alt=&quot;' . $row["Nome"] . '&quot;/>
	<div class=&quot;prodLi&quot;>
		<h2 ' . $lin . '>' . $row["Nome"] . '</h2>
		<p>Prezzo: ' . $row["Prezzo"] . '€</p>
		<form action=&quot;quantitacarr.php?prod=' . $row["Nome"] . '&amp;idoic=' . $row["OrdineInCorso"] . '&quot; method="post" onsubmit=&quot;return validateQta(&apos;Qta' . $i . '&apos;);&quot;>
			<fieldset>
				<dl>
					<dt><label for="Qta3">Quantità: </label></dt>
					<dd><input type="text" name="Quantita" value="' . $row["Quantita"] . '" id="Qta3" maxlength="3" title="Modifica quantità" onblur=&quot;validateQta(&apos;Qta' . $i . '&apos;);&quot;/></dd>
				</dl>
			</fieldset>
			<fieldset>
				<input type="submit" class="pulsanti aggQta" value="Aggiorna" title="Aggiorna la quantità"/>
			</fieldset>
		</form>
	</div>
		<form action="rimuoviCarr.php?prod=' . $row["Nome"] . '&amp;idoic=' . $row["OrdineInCorso"] . '" method="post" class="removeCart" >
			<fieldset>
				<input type="submit" class="pulsanti" value="Rimuovi"/>
			</fieldset></form>'));
$x->setAttribute('class' , 'prodotti');
$i++;
}
$y = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement('a' , 'Prosegui'));
$y->setAttribute('class' , 'pulsanti');
$y->setAttribute('href' , 'acquisto.php');
$y->setAttribute('id' , 'prosegui'); }
else{
	$z = $xpath->query("//*[@id='content']")->item(0);
	$z->removeChild($z->firstChild);
	$z->removeChild($z->firstChild);
	$xpath->query("//*[@id='vuotoCarr']")->item(0)->appendChild($doc->createElement('h1' , 'Il Carrello è vuoto!'));
	$z = $xpath->query("//*[@class='boxW']")->item(0);
	$z->appendChild($doc->createElement('p' , 'Nel Suo carrello non è stato trovato alcun alcolico!'));
	$z->appendChild($doc->createElement('p' , 'Può trovare i nostri prodotti nella nostra <a href="index.php"><span xml:lang="en">Home page</span></a>')); 
}
print decod($doc->saveXML());
$result->free();
$conn->close();
?>
