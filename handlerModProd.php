<?php
if(!file_exists("filtro.php") ||
        !file_exists("decodifica.php") ||
        !file_exists('html/modProd.html') ||
        !file_exists("loadImg.php") ||
        !file_exists("printProd.php") ||
        !file_exists("showErr.php") ||
        !file_exists("prod.php")){ header('Location:404.php');exit; }
        include_once"decodifica.php";
        include_once"showErr.php";
        include_once"printProd.php";
        include_once"loadImg.php";
        include_once"filtro.php";
        include_once"prod.php";
        $Nom = $Prz = $Ct = $Sct = $Ann = $Prodt = $mess = $Lng = "";
	$old = false;
	$vn = filter_input(INPUT_GET , 'vnome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $pag = filter_input(INPUT_GET , 'pagina' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $codice = filter_input(INPUT_GET , 'COD' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	if(empty($pag) || !ctype_digit($pag))
                        { $pag = 0; }       
 	if(empty($codice) || !ctype_digit($codice))
                        { header("Location:404.php");exit; }
        $nom = filter_input(INPUT_POST , 'Nome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($nom)) { $Nom = "errore: nome vuoto."; }
        $prez = filter_input(INPUT_POST , 'Prezzo' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($prez)) { $Prz = "errore: prezzo vuoto."; }
        $cat = filter_input(INPUT_POST , 'Categoria' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($cat)) { $Ct = "errore: categoria vuota."; }
        $lng = filter_input(INPUT_POST , 'lang' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($lng)) { $Lng = "errore: lingua vuota."; }
        $scat = filter_input(INPUT_POST , 'Sottocategoria' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        $ann = filter_input(INPUT_POST , 'Anno' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $prodt = filter_input(INPUT_POST , 'Produttore' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($lng)) { $Lng = "errore: lingua vuota."; }
        if(empty($prodt)) { $Prodt = "errore: produttore vuoto."; }
        $doc = new DOMDocument();
        $doc->load("html/modProd.html");
	$doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $xpath = new DOMXpath($doc);
if(!$Nom && !$Prz && !$Ct && !$Lng && !$Prodt){
        $nom = filtroRic($nom);
        $prez = filtroRic($prez);
        $cat = filtroBase($cat);
        $scat = filtroBase($scat);
	 $ann = filtroBase($ann);
        $prodt = filtroBase($prodt);
        $lng = filtroRic($lng);
        $prod = new Prodotto($codice , $nom , $prez , $cat , $scat , $ann , $prodt , $lng);
        if($prod->noErrors()){
		$nom = str_replace(" " , "" , $nom);
                rename("img/" . $vn . ".jpg" , "img/" . $nom . ".jpg");
                $mess = loadImg($nom , false);
                if(!$mess && $prod->insert($codice)){
		$x = $xpath->query("//*[@class='boxW']")->item(0)->appendChild($doc->createElement('div' , ''));
        $aux = 'handlerModProd.php?COD=' . $codice . '&pagina=' . $pag . '&vnome=' . $nom;
        $xpath->query("//*[@action='handlerModProd.php']")->item(0)->setAttribute('action' , $aux );
        $x->setAttribute('id' , 'esito');
        $x->appendChild($doc->createElement('h2' , 'Modifiche completate con successo!'));
        $x->appendChild($doc->createElement('p' , "torna al tuo <a href='accountAm.php' xml:lang='en' rel='nofollow'>account</a>."));
		}
                else{
			showErr(false , $xpath->query("//*[@class='boxW']") , 'div' , false , false , $doc);
		showErr(false , $xpath->query("//*[@class='boxW']") , 'div' , 'id' , 'esito' , $doc);
                showErr('Inserimento fallito , ritorna alla lista prodotti e riprova!' , $xpath->query("//*[@id='esito']") ,
                        'h2' , false , false , $doc);
                showErr('' , $xpath->query("//*[@id='esito']") , 'p' , false , false , $doc);
                showErr('Torna al tuo <span xml:lang="en">account</span>' , $xpath->query("//*[@id='esito']/p") , 'a' , 'href' ,
                        'accountAm.php' , $doc);
                $xpath->query("//*[@id='esito']/p/a")->item(0)->setAttribute('rel' , 'nofollow'); } }
        else {
		$old = true;
                $Nom = $prod->getErrNom();
                $Prz = $prod->getErrPr();
                $Prodt = $prod->getErrProd();
                $Ct = $prod->getErrCat();
                $Lng = $prod->getErrLingua();
                $Sct = $prod->getErrSubCat();
                $Ann = $prod->getErrAnno();
} }
if($mess) { showErr($mess , $xpath->query("//*[@type='file']/..") , 'p' , 'class' , 'errin' , $doc); }
if($Nom) showErr($Nom , $xpath->query("//*[@name='Nome']/..") , 'p' , 'class' , 'errin' , $doc);
if($Prz) showErr($Prz , $xpath->query("//*[@name='Prezzo']/..") , 'p' , 'class' , 'errin' , $doc);
if($Prodt) showErr($Prodt , $xpath->query("//*[@name='Produttore']/..") , 'p' , 'class' , 'errin' , $doc);
if($Ct) showErr($Ct , $xpath->query("//*[@name='Categoria']/..") , 'p' , 'class' , 'errin' , $doc);
if($Lng) showErr($Lng , $xpath->query("//*[@id='inLingua']") , 'p' , 'class' , 'errin' , $doc);
if($Sct && $scat) showErr($Sct , $xpath->query("//*[@name='Sottocategoria']/..") , 'p' , 'class' , 'errin' , $doc);
if($Ann && $ann) showErr($Ann , $xpath->query("//*[input[@name='Anno']/..") , 'p' , 'class' , 'errin' , $doc);
        PrintDatiProd($xpath , $nom , $prez , $cat , $scat , $ann , $prodt , $lng);
	if($old){
        $aux = 'handlerModProd.php?COD=' . $codice . '&pagina=' . $pag . '&vnome=' . $vn;
        $xpath->query("//*[@action='handlerModProd.php']")->item(0)->setAttribute('action' , $aux ); }
        print decod($doc->saveXML());
?>
