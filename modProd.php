<?php
if(
        !file_exists("printProd.php") ||
        !file_exists("funLog.php") ||
        !file_exists("prodottoR.php") ||
        !file_exists("decodifica.php") ||
        !file_exists('html/modProd.html')){ header('Location:404.php');exit; }
        include_once"decodifica.php";
        include_once"prodottoR.php";
        include_once"funLog.php";
        include_once"printProd.php";
            inizio();
                rigeneraId(false,false,false,false);
                if(empty($_SESSION['Admin']))
                        { header('Location:loginAm.php');exit; }
        $vnom = filter_input(INPUT_GET , 'vnome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $pag = filter_input(INPUT_GET , 'pagina' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $cod = filter_input(INPUT_GET , 'COD' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
         if(!$pag) $pag = 0;
        if(empty($cod) || !ctype_digit($cod))
                        { header('Location:404.php');exit; }
   	$doc = new DOMDocument();
	$doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->load("html/modProd.html");
        $xpath = new DOMXpath($doc);
	$p = new ProdottoR($cod);
        $nom = $p->getNome();
        $aux = 'handlerModProd.php?COD=' . $cod . '&pagina=' . $pag . '&vnome=' . str_replace(" " , "" , $vnom);
        $xpath->query("//*[@action='handlerModProd.php']")->item(0)->setAttribute('action' , $aux );
        PrintDatiProd($xpath , $nom , $p->getPrezzo() , $p->getCat() , $p->getSubCat() , $p->getAnno() , $p->getProd() , $p->getLingua());
      print decod($doc->saveXML()); 
?>
