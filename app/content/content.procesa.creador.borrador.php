<?php require_once __DIR__ . '/adaptabilidad.php';
if(!file_exists("{$Web['directorio']}panel/app/creador/creadores/{$ACR_FORM['creador']}/{$ACR_FORM['creador']}.php")){ die("El creador <strong>{$ACR_FORM['creador']}</strong> no existe."); }
$AXR = $ACR_FORM; $AX = $AC_FORM; ?>