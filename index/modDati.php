<?php
if(
        !file_exists("printDati.php") ||
        !file_exists("clienteR.php") ||
        !file_exists("funLog.php") ||
        !file_exists("decodifica.php") ||
        !file_exists('html/modificaDati.html')){ header('Location:404.php');exit; }
        include_once"decodifica.php";
        include_once"clienteR.php";
        include_once"printDati.php";
        include_once"funLog.php";
inizio();
rigeneraId(false,false,false,false);
if(empty($_SESSION['Email']) || empty($_SESSION['Nome'])){ header('Location:login.php');exit; }
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load("html/modificaDati.html");
$xpath = new DOMXpath($doc);
$xpath->query("//*[@id='pulsanteA']")->item(0)->nodeValue = $_SESSION['Nome'];
$p = new ClienteR($_SESSION['Email']);
PrintDati($xpath , $doc , $p->getNome() , $_SESSION['Email'] , $p->getCogn() , false , false ,
                        $p->getCitta() , $p->getInd() , $p->getTel() , $p->getCartaT() ,
                        $p->getCartaN() , $p->getIva() , $p->getData());
print decod($doc->saveXML());
?>
