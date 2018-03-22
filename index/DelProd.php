<?php
if(!file_exists("connection_db.php")){ header('Location:404.php');exit; }
        include_once"connection_db.php";
        $pag = filter_input(INPUT_GET , 'pagina' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $cod = filter_input(INPUT_GET , 'COD' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
         if(!$pag) $pag = '0';
        if(empty($cod) || !ctype_digit($cod) || !ctype_digit($pag))
                        { header('Location:404.php');exit; }
        if(delProd($cod)){ header('Location:listaProd.php?pagina=' . $pag);exit; }
        else{ header('Location:404.php');exit; }
function delProd($cod){
global $conn;
$ok = false;
if($in = $conn->prepare("UPDATE Prodotto SET Disponibile = 1 ^ Disponibile WHERE Codice = ?")){
$in->bind_param('i' , $cod);
if($in->execute()){ $ok = true; }
$in->close(); }
$conn->close();
return $ok; }
?>
