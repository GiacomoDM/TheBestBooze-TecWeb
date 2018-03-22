<?php
if(
        !file_exists("html/info.html") ||
        !file_exists("funLog.php"))
        { header('Location:404.php');exit; }
                include_once"funLog.php";
                include_once"loginName.php";
inizio();
rigeneraId(false,false,false,false);
$user = "";
if(!empty($_SESSION['Nome']))
        { $user = $_SESSION['Nome'];$admin = false; }
if(!empty($_SESSION['Admin']))
        { $user = $_SESSION['Admin'];$admin = true; }
if($user) loginName(file_get_contents('html/info.html'),$user,$admin);
else echo file_get_contents("html/info.html");
?>

