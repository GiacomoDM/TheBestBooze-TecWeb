<?php
if(     !file_exists("clienteR.php") ||
        !file_exists("connection_db.php") ||
        !file_exists("decodifica.php") ||
        !file_exists("showErr.php") ||
        !file_exists("html/login.html") ||
        !file_exists("funLog.php"))
        { header('Location:404.php');exit; }
                include_once"decodifica.php";
                require_once"connection_db.php";
                include_once"showErr.php";
                include_once"funLog.php";
                include_once"clienteR.php";
$errE = $errP = "";
$email = filter_input(INPUT_POST , 'Email' , FILTER_SANITIZE_EMAIL);
$pwd = filter_input(INPUT_POST , 'Passwd' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty($email))$errE = "errore: <span xml:lang='en'>E-mail</span> vuota.";
if(empty($pwd))$errP = "errore: <span xml:lang='en'>Password</span> vuota.";
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load("html/login.html");
$xpath = new DOMXpath($doc);
if(!$errE && !$errP){
if(strlen($email) <= 64 && filter_var($email , FILTER_VALIDATE_EMAIL) && Login( $email , $pwd , $conn)) {
                $cl = new ClienteR($email);
		inizio();
                rigeneraId($email , $cl->getNome() , 'Email' , 'Nome');
                unset($doc);
                header('Location:index.php');exit; }
                else{
                        showErr("errore: coppia <span xm:lang='en'>E-mail</span> , <span xm:lang='en'>password</span> errata." ,
                                        $xpath->query("//*[@for='inEmail']/../../..") , 'legend' , 'class' , 'errin' , $doc);
                        Report($xpath , $email , $pwd);
                echo decod($doc->saveXML()); } }
else{
        if($errE)showErr($errE , $xpath->query("//*[@name='Email']/..") , 'p' , 'class' , 'errin' , $doc);
        if($errP)showErr($errP , $xpath->query("//*[@name='Passwd']/..") , 'p' , 'class' , 'errin' , $doc);
        Report($xpath , $email , $pwd);
        echo decod($doc->saveXML()); }
function Report($xpath , $email , $pwd){
        if($email) $xpath->query("//*[@name='Email']")->item(0)->setAttribute("value" , $email);
        if($pwd) $xpath->query("//*[@name='Passwd']")->item(0)->setAttribute('value' , $pwd);
}
?>
