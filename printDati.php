<?php
function PrintDati($xpath , $doc , $nom , $email , $cogn , $pwd , $pwd2 , $cit , $ind , $tel , $ct , $cn , $iva , $dat){
if($nom) $xpath->query("//*[@name='Nome']")->item(0)->setAttribute('value' , $nom);
if($email) $xpath->query("//*[@name='Email']")->item(0)->setAttribute('value' , $email);
if($cogn) $xpath->query("//*[@name='Cognome']")->item(0)->setAttribute('value' , $cogn);
if($pwd) $xpath->query("//*[@name='Passwd']")->item(0)->setAttribute('value' , $pwd);
if($pwd2) $xpath->query("//*[@name='Passwd2']")->item(0)->setAttribute('value' , $pwd2);
if($cit) $xpath->query("//*[@name='Citta']")->item(0)->setAttribute('value' , $cit);
if($ind) $xpath->query("//*[@name='Indirizzo']")->item(0)->setAttribute('value' , $ind);
if($tel) $xpath->query("//*[@name='Telefono']")->item(0)->setAttribute('value' , $tel);
if($ct) $xpath->query("//*[@value='$ct']")->item(0)->setAttribute('selected' , 'selected');
if($cn) $xpath->query("//*[@name='Num']")->item(0)->setAttribute('value' , $cn);
if($iva) $xpath->query("//*[@name='IVA']")->item(0)->setAttribute('value' , $iva);
if($dat) $xpath->query("//*[@name='Data']")->item(0)->setAttribute('value' , $dat);
}
?>
