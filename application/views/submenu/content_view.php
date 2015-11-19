<?php
    if(isset($content) && $content != false){
        echo $content['contenido'];
    } else {
        echo 'No hay contenido';
    }
?>