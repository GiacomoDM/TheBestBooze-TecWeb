<?php
if(
        !file_exists("connection_db.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("showErr.php") ||
        !file_exists("html/loginAm.html") ||
        !file_exists("funLog.php"))
        { header('Location:404.php');exit; }
                include_once"decodifica.php";
                require_once"connection_db.php";
                include_once"showErr.php";
                include_once"funLog.php";
$errE = $errP = "";
$email = filter_input(INPUT_POST , 'Nome' , FILTER_SANITIZE_EMAIL);
$pwd = filter_input(INPUT_POST , 'Passwd' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty($email))$errE = "errore: Nome vuoto.";
if(empty($pwd))$errP = "errore: <span xml:lang='en'>Password</span> vuota.";
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load("html/loginAm.html");
$xpath = new DOMXpath($doc);
if(!$errE && !$errP){
if(strlen($email) <= 30 && LoginAM( $email , $pwd , $conn)) {
                unset($doc);
		inizio();
		rigeneraId($email , false , 'Admin' , false);
                header('Location:accountAm.php');exit; }
                else{
                        showErr("errore: coppia Nome , <span xm:lang='en'>password</span> errata." ,
                                        $xpath->query("//*[@for='inputNome']/../../..") , 'legend' , 'class' , 'errin' , $doc);
                        Report($xpath , $email , $pwd);
                echo decod($doc->saveXML()); } }
else{
        if($errE)showErr($errE , $xpath->query("//*[@name='Nome']/..") , 'p' , 'class' , 'errin' , $doc);
        if($errP)showErr($errP , $xpath->query("//*[@name='Passwd']/..") , 'p' , 'class' , 'errin' , $doc);
        Report($xpath , $email , $pwd);
        echo decod($doc->saveXML()); }
function Report($xpath , $email , $pwd){
        if($email) $xpath->query("//*[@name='Nome']")->item(0)->setAttribute("value" , $email);
        if($pwd) $xpath->query("//*[@name='Passwd']")->item(0)->setAttribute('value' , $pwd);
}
?>
