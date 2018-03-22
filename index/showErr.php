<?php
function showErr($i , $el , $tag , $attr , $value , $doc){
if($el !== NULL && $el !== FALSE){
        $x = $el->item(0)->appendChild($doc->createElement($tag , $i));
        if($x && $attr !== FALSE && $attr !== NULL)$x->setAttribute($attr , $value); }}
?>

