<?php
if(!file_exists("html/ricerca.html") ||
        !file_exists("funLog.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("connection_db.php") ||
        !file_exists("filtro.php") ||
        !file_exists("filtro.php") )
                { header("Location:404.php"); exit;}
include_once "filtro.php";
include_once "decodifica.php";
include_once "funLog.php";
include_once "connection_db.php";
inizio();
rigeneraId(false,false,false,false);
global $conn;
$ord = filter_input(INPUT_GET , 'order' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$cat = filter_input(INPUT_GET , 'categ' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$ricerca = filter_input(INPUT_GET , 'ric' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$p = filter_input(INPUT_GET, 'pag' , FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(!is_numeric($p) || !isset($p)) $p=1;
$ricerca = filtroRic($ricerca);
$p = filtroRic($p);
$ok = false;
$arr1 = array('ORDER BY Nome' ,'ORDER BY Prezzo' , 'ORDER BY Prezzo DESC');
$arr = array('alf' , 'prz1' , 'prz2');
for($i = 0; $i < 3 && !$ok; $i++){
        if(strcmp($arr[$i] , $ord) === 0)
                { $ok = true ; $ord = $arr1[$i]; }}
$ok = false;
$CAT = array('Vino' , 'Birra' , 'Superalcolico' , 'Sidro');
for($i = 0; $i < 4 && !$ok; $i++){
        if(strcmp($CAT[$i] , $cat) === 0){
                $ok = true ;
                $sql = "SELECT * FROM Prodotto WHERE Categoria= '$cat' AND Nome LIKE '%$ricerca%' AND Disponibile = 1 $ord"; }}
if(!$ok)
        { $sql = "SELECT * FROM Prodotto WHERE (Nome LIKE '%$ricerca%' OR Categoria LIKE '%$ricerca%' OR Sottocategoria LIKE '%$ricerca%') AND Disponibile = 1 $ord"; }
$usl = "";
if(!empty($_SESSION['Nome']))
       { $usl = $_SESSION['Nome'];$admin = false; } 
if(!empty($_SESSION['Admin']))
       { $usl = $_SESSION['Admin'];$admin = true; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load('html/ricerca.html');
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
else{ 
	$xpath->query("//*[@id='pulsanteA']")->item(0)->setAttribute('href' , 'accountAm.php');
	$xpath->query("//*[@accesskey='k']")->item(0)->setAttribute('href' , ''); }
$x = $xpath->query("//*[@id='areapers']")->item(0)->appendChild($doc->createElement('div' , '<form action="logout.php" method="post">
                <fieldset><input type="submit" class="pulsanti" name="esci" value="Log-out" accesskey="o"/></fieldset></form>'));
$x->setAttribute('id' , 'comparsa');
}
$xpath->query("//*[@action='ricerca.php']")->item(0)->setAttribute('action' , "?categ=$cat&ric=$ricerca&order=$ord");
$xpath->query("//*[@action='ricerca.php']")->item(0)->setAttribute('action' , "?categ=$cat&ric=$ricerca");
(!$ricerca) ? $xpath->query("//*[@id='ric']")->item(0)->nodeValue = $cat : $xpath->query("//*[@id='ric']")->item(0)->nodeValue = $cat . "-" . $ricerca;
if(!$result = $conn->query($sql))
                { header('Location:404.php');exit; }
$n = $result->num_rows;
$i = 0;
if(!$n){
$s = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('div' , '<h2>Non abbiamo trovato nessun prodotto!</h2><p>Siamo spiacenti ma nessun prodotto corrisponde alla sua ricerca.</p><p> Per favore ritenta la ricerca in modo meno specifico , controlla di aver digitato correttamente il nome del prodotto , oppure indica solo la categoria.</p>'));
$s->setAttribute('id' , 'noconn'); }
if($n > 0){
while($row = $result->fetch_array(MYSQLI_ASSOC)){
        if($i < ($p * 10) && $i >= (($p - 1) * 10)){
if(strcmp($row['Lingua'] , 'it') !== 0)
$x = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('div' ,
        '<a href="prodotto.php?prod=' . $row['Nome'] . '">
        <img src="img/' . str_replace(" " , "" , $row['Nome']) . '.jpg" alt="' . $row['Nome'] . '" />
        <span class="titolo" xml:lang="' . $row['Lingua'] . '">' . $row['Nome'] . '</span>
        <span>&nbsp;Prezzo:' . $row['Prezzo'] . ' €</span>
        </a>'));
else
$x = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement('div' ,
        '<a href="prodotto.php?prod=' . $row['Nome'] . '">
        <img src="img/' . str_replace(" " , "" , $row['Nome']) . '.jpg" alt="' . $row['Nome'] . '" />
        <span class="titolo">' . $row['Nome'] . '</span>
        <span>&nbsp;Prezzo:' . $row['Prezzo'] . ' €</span>
        </a>'));
        $x->setAttribute('class' , 'prodotto'); }
$i++; }
$n = ceil($n / 10);
$aux = "";
$auxT = $p - 1;
$y = $xpath->query("//*[@id='content']")->item(0)->appendChild($doc->createElement("div" , ""));
$y->setAttribute('class' , 'paging');
$y->appendChild($doc->createElement("span" , "Vai alla pagina:"));
$z = $y->appendChild($doc->createElement("ul" , ""));
if($p > 1)
         $z->appendChild($doc->createElement("li" , "&lt;a href='?categ=$cat&amp;ric=$ricerca&amp;order=$ord&amp;pag=$auxT'&gt;Pagina precedente&lt;/a&gt;"));
        for($i = 1; $i <= $n; $i++){
                if($p == $i) { $active = $z->appendChild($doc->createElement("li" , "&lt;a&gt;$i&lt;/a&gt;")); $active->setAttribute('class' , 'active'); }
                else $z->appendChild($doc->createElement("li" , "&lt;a href='?categ=$cat&amp;ric=$ricerca&amp;order=$ord&amp;pag=$i'&gt;$i&lt;/a&gt;")); }
$auxT = $p + 1;
if($auxT <= $n)
        $z->appendChild($doc->createElement("li" ,"&lt;a href='?categ=$cat&amp;ric=$ricerca&amp;order=$ord&amp;pag=$auxT'&gt;Pagina successiva&lt;/a&gt;")); }
print decod($doc->saveXML());
$result->free();
$conn->close();
?>
