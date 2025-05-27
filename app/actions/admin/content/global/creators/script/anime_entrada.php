<?php $lista_categorias = [];
foreach (DATA->Read("creator/list-tags")["genres-anime"] ?? [] as $value) {
    $lista_categorias[$value] = Language(["categories-tags", $value]);
}