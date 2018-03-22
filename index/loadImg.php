<?php
function loadImg($nome , $save){
ini_set('max_file_uploads', 1);
if(!$save && !is_uploaded_file($_FILES['pic']['tmp_name'])) return '';
if ($save && !is_uploaded_file($_FILES['pic']['tmp_name'])) return("errore: nessuno <span xml:lang='en'>file</span> caricato;");
        if(preg_match("/\.jpg$/i" , $_FILES['pic']['name']) !== 1)
                return("errore: formato estensione <span xml:lang='en'>file</span> errato;");
        if($_FILES['pic']['size'] > 358400)
                return("errore: dimensione <span xml:lang='en'>file</span> errata;");
        if($_FILES['pic']['error'] == 0){
                        if(!move_uploaded_file($_FILES['pic']['tmp_name'] , "img/" . str_replace(' ' , '' , $nome) . ".jpg"))
                                { return 'errore : operazione fallita , riprova.'; }}
return false; }
?>
