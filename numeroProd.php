<?php
function numProd($conn){
global $conn;
if($result = $conn->prepare("SELECT COUNT(*) FROM Prodotto")){
        if($result->execute()){
        $result->bind_result($ris);
        $result->fetch();
        $result->close();
        $conn->close();
        return $ris; }
}
$conn->close();
return -1;
}
?>
