<?php
if(
        !file_exists("connection_db.php") &&
        !file_exists("funLog.php") &&
        !file_exists("clienteR.php")){
                header('Location:404.php');exit; }
        include_once"connection_db.php";
        include_once"funLog.php";
        include_once"clienteR.php";
inizio();
rigeneraId(false , false , false , false);
        if(empty($_SESSION['Email'])){ header('Location:login.php');exit; }
        $cliente = new ClienteR($_SESSION['Email']);
        if($cliente->delAll($_SESSION['Email'] , $conn)){ 
        session_start();
        $_SESSION = array();
        session_unset();
        session_destroy();
        header('Location:index.php');exit; }
        else{ header('Location:404.php');exit; }
?>
