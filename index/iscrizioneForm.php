<?php
if(!file_exists("filtro.php") ||
        !file_exists("printDati.php") ||
        !file_exists('html/iscrizione.html') ||
        !file_exists("showErr.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("cliente.php")){ header('Location:404.php');exit; }
        include_once"printDati.php";
        include_once"showErr.php";
        include_once"decodifica.php";
        include_once"filtro.php";
        include_once"cliente.php";
        $E = $P = $P2 = $N = $C = $CC = $IND = $CT = $D = $CN = $I = $T = "";
        $email = filter_input(INPUT_POST, 'Email' , FILTER_SANITIZE_EMAIL);
        if(empty($email)) { $E = "errore: <span xml:lang='en'>E-mail</span> vuota."; }
        $pwd = filter_input(INPUT_POST, 'Passwd' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $pwd2 = filter_input(INPUT_POST, 'Passwd2' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($pwd)) { $P = "errore: <span xml:lang='en'>Password</span> vuota."; }
        if(empty($pwd2)) { $P2 = "errore: conferma <span xml:lang='en'>Password</span> vuota."; }
        $nome = filter_input(INPUT_POST , 'Nome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($nome)) { $N = "errore: nome vuoto."; }
        $cogn = filter_input(INPUT_POST , 'Cognome' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($cogn)) { $C = "errore: cognome vuoto."; }
        $Citta = filter_input(INPUT_POST , 'Citta' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($Citta)) { $CC = "errore: citta vuota."; }
        $ind = filter_input(INPUT_POST , 'Indirizzo' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW);
        if(empty($ind)) { $IND = "errore: indirizzo vuoto."; }
        $tel = filter_input(INPUT_POST , 'Telefono' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $carta = filter_input(INPUT_POST , 'Num' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($carta)) { $CN = "errore: numero carta vuota."; }
        $cartaT = filter_input(INPUT_POST , 'tipoCarta' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($cartaT)) { $CT = "errore: tipo carta vuoto."; }
        $iva = filter_input(INPUT_POST , 'IVA' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $data = filter_input(INPUT_POST , 'Data' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if(empty($data)) { $D = "errore: data vuota."; }
        $doc = new DOMDocument();
	$doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->load("html/iscrizione.html");
        $xpath = new DOMXpath($doc);
if(!$N && !$E && !$C && !$P && !$P2 && !$CC &&
        !$IND && !$CT && !$CN && !$D){
	$iva = filtroBase($iva);
        $carta = filtroBase($carta);
        $cartaT = filtroBase($cartaT);
        $tel = filtroBase($tel);
        $ind = filtroRic($ind);
        $Citta = filtroRic($Citta);
        $cogn = filtroRic($cogn);
        $nome = filtroRic($nome);
        $cliente = new Cliente($nome , $cogn , $email , $pwd , $pwd2 ,
                                $data , $Citta , $iva ,$cartaT , $carta
                                , $ind , $tel , false);
        if($cliente->noErrors()){
                if($cliente->save()){ header('Location:iscrizioneSuccesso.php');exit; }
                else { header('Location:404.php');exit; }
                }
                else {
                        $N = $cliente->getErrN();
                        $C = $cliente->getErrC();
                        $E = $cliente->getErrE();
                        $P = $cliente->getErrP();
                        $P2 = $cliente->getErrP2();
                        $D = $cliente->getErrD();
                        $CC = $cliente->getErrCC();
                        $I = $cliente->getErrI();
                        $CT = $cliente->getErrCT();
                        $CN = $cliente->getErrCN();
                        $IND = $cliente->getErrIND();
                        $T = $cliente->getErrT(); } }
                if($N)showErr($N , $xpath->query("//*[@name='Nome']/..") , 'p' , 'class' , 'errin' , $doc);
                if($E)showErr($E , $xpath->query("//*[@name='Email']/..") , 'p' , 'class' , 'errin' , $doc);
                if($C)showErr($C , $xpath->query("//*[@name='Cognome']/..") , 'p' , 'class' , 'errin' , $doc);
                if($P)showErr($P , $xpath->query("//*[@name='Passwd']/..") , 'p' , 'class' , 'errin' , $doc);
                if($P2)showErr($P2 , $xpath->query("//*[@name='Passwd2']/..") , 'p' , 'class' , 'errin' , $doc);
                if($CC)showErr($CC , $xpath->query("//*[@name='Citta']/..") , 'p' , 'class' , 'errin' , $doc);
                if($IND)showErr($IND , $xpath->query("//*[@name='Indirizzo']/..") , 'p' , 'class' , 'errin' , $doc);
                if($T && $tel)showErr($T , $xpath->query("//*[@name='Telefono']/..") , 'p' , 'class' , 'errin' , $doc);
                if($CT)showErr($CT , $xpath->query("//*[@name='tipoCarta']/..") , 'p' , 'class' , 'errin' , $doc);
                if($CN)showErr($CN , $xpath->query("//*[@name='Num']/..") , 'p' , 'class' , 'errin' , $doc);
                if($I && $iva)showErr($I , $xpath->query("//*[@name='IVA']/..") , 'p' , 'class' , 'errin' , $doc);
		if($D)showErr($D , $xpath->query("//*[@name='Data']/..") , 'p' , 'class' , 'errin' , $doc);
                PrintDati($xpath , $doc , $nome , $email , $cogn , $pwd , $pwd2 , $Citta , $ind , $tel , $cartaT , $carta , $iva , $data);
                print decod($doc->saveXML());
?>
