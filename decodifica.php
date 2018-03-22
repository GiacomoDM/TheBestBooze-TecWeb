<?php
function decod($input){
$arr = array('<?xml version="1.0"?>' => "" , "&#35;" => "#" , "&quot;" => "\"" , "&lt;" => "<" , "&gt;" => ">" , "&#x2019;" => "'");
        foreach($arr as $key => $value) $input = str_replace($key , $value , $input);
        return $input; }
?>
