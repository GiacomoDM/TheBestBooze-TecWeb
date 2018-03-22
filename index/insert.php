<?php
if(!file_exists("carrello.php") ||
!file_exists("connection_db.php") ||
!file_exists("funLog.php") ||
!file_exists("filtro.php")) { header('Location:404.php');exit; }
include_once "filtro.php";
include_once "connection_db.php";
include_once "funLog.php";
inizio();
rigeneraId(false,false,false,false);
if(empty($_SESSION['Email']))
  { header('Location:login.php');exit; }
global $conn;
$y = filter_input(INPUT_GET , 'idprod' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$costounitario = filter_input(INPUT_GET , 'cunit' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$q = filter_input(INPUT_POST, 'Quantita', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$y = filtroRic($y);
$costounitario = filtroRic($costounitario);
$q = filtroRic($q);
if(!is_numeric($q) || empty($q) || $q < 1) {
	if(!$result = $conn->query("SELECT * FROM Prodotto WHERE Codice='$y' AND Disponibile='1'"))
  { $conn->close();header('Location:404.php');exit; }
$row = $result->fetch_array(MYSQLI_ASSOC);
$result->free();
$conn->close();
header("Location:prodotto.php?prod=" . urlencode($row['Nome']) . "&amp;err=true");exit; }
if($q > 999) $q = 999;
$us = $_SESSION['Email'];
if(empty($us) || !$result = $conn->query("SELECT * FROM OrdineInCorso JOIN Cliente ON Cliente=Email WHERE Email='$us'")) { $conn->close();header('Location:404.php');exit; }
if ($result->num_rows === 0) {
	$d = date('Y-m-d');
	if($conn->query("INSERT INTO OrdineInCorso (Cliente, Data) VALUES ('$us', '$d')")) { $idoic = $conn->insert_id; }
	else { $conn->close();header('Location:404.php');exit; }}
else { $row = $result->fetch_array(MYSQLI_ASSOC);$idoic=$row['ID']; }
if(!$result = $conn->query("SELECT * from Cliente join OrdineInCorso ON Email=Cliente JOIN Carrello ON ID=OrdineInCorso WHERE Email='$us' AND Prodotto='$y'")) {header('Location:404.php');exit;}
$row = $result->fetch_array(MYSQLI_ASSOC);
$costo = $costounitario * $q;
if ($result->num_rows === 1) { $sql = "UPDATE Carrello SET Quantita= $q, Costo='$costo' WHERE Prodotto= $y AND OrdineInCorso= $idoic"; }
else{ $sql = "INSERT INTO Carrello (Prodotto, OrdineInCorso, Quantita, Costo)	VALUES ('$y', '$idoic', '$q', '$costo')"; }
if(!$conn->query($sql)) { $conn->close();header('Location:404.php');exit; }
$result->free();
$conn->close();
header('Location:carrello.php');
exit;
?>
