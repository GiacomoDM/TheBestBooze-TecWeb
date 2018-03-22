<?php
if(!file_exists("html/prodotto.html") ||
        !file_exists("decodifica.php") ||
        !file_exists("connection_db.php") ||
		!file_exists("funLog.php") ||
        !file_exists("filtro.php"))
        { header('Location:404.php');exit; }
include_once "decodifica.php";
include_once "filtro.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
global $conn;
$q = filter_input(INPUT_GET , 'prod' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$q = filtroRic($q);
$err = filter_input(INPUT_GET , 'err' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(!$result = $conn->query("SELECT * FROM Prodotto WHERE Nome='$q' AND Disponibile='1'"))
	{ $conn->close();header('Location:404.php');exit; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/prodotto.html');
$xpath = new DOMXpath($doc);
$usl = "";
$admin = '';
if(!empty($_SESSION['Nome']))
        { $usl = $_SESSION['Nome'];$admin = false; }
if(!empty($_SESSION['Admin']))
        { $usl = $_SESSION['Admin'];$admin = true; }	

$xpath->query("//*[@accesskey='a']")->item(0)->setAttribute('title' , 'Accedi alla tua area personale');
if($usl)
	$xpath->query("//*[@accesskey='a']")->item(0)->nodeValue = $usl;
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

if($result->num_rows === 1){
while($row = $result->fetch_array(MYSQLI_ASSOC)){
$y = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('h1' , $row['Nome']));
if(strcmp($row['Lingua'] , 'it') !== 0)
	$y->setAttribute("xml:lang" , $row['Lingua']);
if($row['Sottocategoria']) $temp = '<li>Sottocategoria: ' . $row['Sottocategoria'] . '</li>';
else $temp = '';
if(!$admin) $submit = '<fieldset><input type="submit" class="pulsanti" name="aggiungi" value="Aggiungi al Carrello"/></fieldset>';
else $submit = '';
$x = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('div' , '
    <img src="img/' . str_replace(' ' , '' , $row['Nome']) . '.jpg" alt="' . $row['Nome'] . '"/>
    <div id="singolo">
      <ul>
        <li>Prezzo: ' . $row["Prezzo"] . '€</li>
        <li>Categoria: ' . $row["Categoria"] . '</li>
        ' . $temp . '
        <li>Anno: ' . $row["Anno"] . '</li>
        <li>Produttore: ' . $row["Produttore"] . '</li>
      </ul>
      <form action="insert.php?idprod=' . $row["Codice"] . '&amp;cunit=' . $row["Prezzo"] . '" method="post" onsubmit="return callValidateAll(&apos;checkQta&apos;);">
        <fieldset><dl><dt>
          <label for="Qta">Quantità: </label></dt><dd>
          <input type="text" id="Qta" name="Quantita" value="1" title="Inserisci quantità"/></dd></dl>
        </fieldset>
	' . $submit . '
      </form>
    </div>'));
$x->setAttribute("id" , 'box_singolo');
if(isset($err)) { $z = $xpath->query("//*[@id='Qta']/..")->item(0)->appendChild($doc->createElement('p' , "errore: quantità non valida"));$z->setAttribute('class' , 'errin'); }}}
print decod($doc->saveXML());
$result->free();
$conn->close();
?>
