<?php
if(!file_exists(RAIZ . "app/views/admin/creators/{$ACR_FORM['creador']}-view.php")){
    die(Language('creator-not-found', 'alert', ['value' => "<strong>{$ACR_FORM['creador']}</strong>"]));
}
$AXR = $ACR_FORM; $AX = $AC_FORM; ?>