<?php
function PrintDatiProd($xpath , $nom , $prez , $cat , $scat , $ann , $prodt , $lng){
if($nom)$xpath->query("//*[@name='Nome']")->item(0)->setAttribute('value' , $nom);
if($prez)$xpath->query("//*[@name='Prezzo']")->item(0)->setAttribute('value' , $prez);
if($prodt)$xpath->query("//*[@name='Produttore']")->item(0)->setAttribute('value' , $prodt);
if($cat)$xpath->query("//*[@value='$cat']")->item(0)->setAttribute('selected' , 'selected');
if($scat && $scat !== NULL)$xpath->query("//*[@name='Sottocategoria']")->item(0)->setAttribute('value' , $scat);
if($ann && $ann !== NULL)$xpath->query("//*[@name='Anno']")->item(0)->setAttribute('value' , $ann);
if($lng)$xpath->query("//*[@value='$lng']")->item(0)->setAttribute('checked' , 'checked');
} 
?>

