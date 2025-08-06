<?php $lista_categorias = [];
foreach (Daamper::$data->Read("creator/list-tags")["genres-anime"] ?? [] as $value) {
    $lista_categorias[$value] = Language(["categories-tags", $value]);
}