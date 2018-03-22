<?php
if(!file_exists("filtro.php") ||
        !file_exists("decodifica.php") ||
        !file_exists('html/addProd.html') ||
        !file_exists("numeroProd.php") ||
        !file_exists("connection_db.php") ||
        !file_exists("loadImg.php") ||
        !file_exists("printProd.php") ||
        !file_exists("funLog.php") ||
        !file_exists("showErr.php") ||
        !file_exists("prod.php")){ header('Location:404.php');exit; }
        include_once"decodifica.php";
        include_once"showErr.php";
        include_once"printProd.php";
        include_once"loadImg.php";
        include_once"connection_db.php";
        include_once"numeroProd.php";
        include_once"funLog.php";
        include_once"filtro.php";
        include_once"prod.php";
        inizio();
                rigeneraId(false,false,false,false);
                if(empty($_SESSION['Admin']))
                        { header('Location:loginAm.php');exit; }
        $Nom = $Nom2 = $Prz = $Ct = $mess = $Sct = $Ann = $Prodt = $Lng = "";
        $nom = filter_input(INPUT_POST , 'Nome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($nom)) { $Nom = "errore: nome vuoto."; }
        $prez = filter_input(INPUT_POST , 'Prezzo' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($prez)) { $Prz = "errore: prezzo vuoto."; }
        $cat = filter_input(INPUT_POST , 'Categoria' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($cat)) { $Ct = "errore: categoria vuota."; }
        $lng = filter_input(INPUT_POST , 'lang' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($lng)) { $Lng = "errore: lingua vuota."; }
        $scat = filter_input(INPUT_POST , 'Sottocategoria' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $ann = filter_input(INPUT_POST , 'Anno' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $prodt = filter_input(INPUT_POST , 'Produttore' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($prodt)) { $Prodt = "errore: produttore vuoto."; }
        $doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
        $doc->load("html/addProd.html");
        $xpath = new DOMXpath($doc);
if(!$Nom && !$Prz && !$Ct && !$Prodt && !$Lng){
        $codice = numProd($conn);
        if($codice < 0){ header('Location:404.php');exit; }
        $codice++;
        $codice = strval($codice);
        $lng = filtroRic($lng);
	$nom = filtroRic($nom);
        $prez = filtroRic($prez);
        $cat = filtroBase($cat);
        $scat = filtroBase($scat);
        $ann = filtroBase($ann);
        $prodt = filtroBase($prodt);
        $prod = new Prodotto($codice , $nom , $prez , $cat , $scat , $ann , $prodt , $lng);
	$Nom2 = $prod->NomExists();
if(ctype_digit($codice))
        if($prod->noErrors() && !$Nom2){
		$mess = loadImg($nom , true);
                if(!$mess && $prod->save($conn)){
		$x = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement('div' , ''));
        $x->setAttribute('id' , 'esito');
        $x->appendChild($doc->createElement('h2' , 'Inserimento completato con successo!'));
        $x->appendChild($doc->createElement('p' , "Per tornare al tuo <a href='accountAm.php' xml:lang='en' rel='nofollow'>account</a>.")); }
                else{
		showErr(false , $xpath->query("//*[@class='boxW']") , 'div' , false , false , $doc);
		showErr(false , $xpath->query("//*[@class='boxW']") , 'div' , 'id' , 'esito' , $doc);
                showErr('Inserimento fallito , riprova!' , $xpath->query("//*[@id='esito']") ,
                        'h2' , false , false , $doc);
                showErr('' , $xpath->query("//*[@id='esito']") , 'p' , false , false , $doc);
                showErr('Torna alla pagina principale' , $xpath->query("//*[@id='esito']/p") , 'a' , 'href' ,
                        'accountAm.php' , $doc);
                $xpath->query("//*[@id='esito']/p/a")->item(0)->setAttribute('rel' , 'nofollow'); }}
        else {
                $Nom = $prod->getErrNom();
                $Prz = $prod->getErrPr();
                $Prodt = $prod->getErrProd();
                $Ct = $prod->getErrCat();
                $Lng = $prod->getErrLingua();
                $Sct = $prod->getErrSubCat();
                $Ann = $prod->getErrAnno();
} }
if($mess) showErr($mess , $xpath->query("//*[@type='file']/..") , 'p' , 'class' , 'errin' , $doc);
if($Nom2) showErr($Nom2 , $xpath->query("//*[@name='Nome']/..") , 'p' , 'class' , 'errin' , $doc);
if($Nom) showErr($Nom , $xpath->query("//*[@name='Nome']/..") , 'p' , 'class' , 'errin' , $doc);
if($Prz) showErr($Prz , $xpath->query("//*[@name='Prezzo']/..") , 'p' , 'class' , 'errin' , $doc);
if($Prodt) showErr($Prodt , $xpath->query("//*[@name='Produttore']/..") , 'p' , 'class' , 'errin' , $doc);
if($Ct) showErr($Ct , $xpath->query("//*[@name='Categoria']/..") , 'p' , 'class' , 'errin' , $doc);
if($Lng) showErr($Lng , $xpath->query("//*[@id='inLingua']") , 'p' , 'class' , 'errin' , $doc);
if($Sct && $scat) showErr($Sct , $xpath->query("//*[@name='Sottocategoria']/..") , 'p' , 'class' , 'errin' , $doc);
if($Ann && $ann) showErr($Ann , $xpath->query("//*[@name='Anno']/..") , 'p' , 'class' , 'errin' , $doc);
PrintDatiProd($xpath , $nom , $prez , $cat , $scat , $ann , $prodt , $lng);
print decod($doc->saveXML());
?>
