<?php
if(!file_exists("filtro.php") ||
!file_exists("connection_db.php"))
{ header('Location:404.php');exit; }
include_once "filtro.php";
include_once "connection_db.php";
$p = filter_input(INPUT_GET , 'prod' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$p = filtroRic($p);
$idoic = filter_input(INPUT_GET , 'idoic' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$idoic = filtroRic($idoic);
global $conn;
if(!$result = $conn->query("SELECT * FROM Prodotto WHERE Nome='$p'")) { $conn->close();header("Location:404.php");exit; }
$row = $result->fetch_array(MYSQLI_ASSOC);
$idp = $row['Codice'];
if(!$result = $conn->query("SELECT * FROM OrdineInCorso JOIN Carrello ON ID=OrdineInCorso WHERE ID= $idoic")) { $conn->close();header('Location:404.php');exit; }
if($result->num_rows < 2){
	if(!$result = $conn->query("DELETE FROM OrdineInCorso WHERE ID = $idoic")) { $conn->close();header('Location:404.php');exit; }} 
if(!$result = $conn->query("DELETE FROM Carrello WHERE Prodotto = $idp AND OrdineInCorso = $idoic")) { $conn->close();header('Location:404.php');exit; }
$conn->close();
header('Location:carrello.php');
exit;
?>
