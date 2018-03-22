<?php
session_start();
if(!file_exists("filtro.php") ||
!file_exists("connection_db.php") ||
!file_exists("funLog.php"))
{ header('Location:404.php');exit; }
include_once "filtro.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
$p=filter_input(INPUT_GET , 'prod' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$p=filtroRic($p);
$q=filter_input(INPUT_POST , 'Quantita' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$q = filtroRic($q);
$idoic=filter_input(INPUT_GET , 'idoic' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$idoic = filtroRic($idoic);
if(!is_numeric($q) || $q == '') {header('Location:carrello.php');exit;}
if($q<1){header("Location:rimuoviCarr.php?prod=$p&idoic=$idoic");exit;}
if($q>999){$q=999;}
$us=$_SESSION['Email'];
global $conn;
$sql = "SELECT * FROM Prodotto WHERE Nome='$p'";
if(!$result=$conn->query($sql)) {header('Location:404.php');exit;}
$row=$result->fetch_array(MYSQLI_ASSOC);
$idp=$row['Codice'];
$newcost=$row['Prezzo']*$q;
$sql = "UPDATE Carrello SET Quantita='$q', Costo=$newcost WHERE Prodotto='$idp' AND OrdineInCorso=$idoic";
if (!$conn->query($sql)) {header('Location:404.php');exit;}
header('Location:carrello.php');
$result=free();
?>
