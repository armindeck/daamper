<?php
$NewTitleLanguage = str_replace("/", "-", str_replace(".php", "", $AC['ruta'].$AC['archivo']));
if (in_array($NewTitleLanguage, Daamper::$data->Read("creator/default")["titles"])) {
    $MOD = ['titulo'];
    if (strtolower($AC['titulo']) == 'undefined'){
        $AC['titulo'] = Language([$NewTitleLanguage, 'title'], 'posts') ?? $AC['titulo'];
    }
}
if ($AC["ruta"] == "p/"){ $AC['titulo'] = Language(["p-profile", 'title'], 'posts') ?? $AC['titulo']; }