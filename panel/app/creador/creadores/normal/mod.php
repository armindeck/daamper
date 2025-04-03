<?php
if (in_array($AC['ruta'].$AC['archivo'], ['error.php', 'search.php'])) {
    $MOD = ['titulo'];
    $AC['titulo'] = strtolower($AC['titulo']) != 'undefined' ? $AC['titulo'] : 
    ($AC['ruta'].$AC['archivo'] == 'error.php' ? Language(['error', 'title'], 'posts') :
    Language('search'));
}
if ($AC['ruta'].$AC['archivo'] == 'panel/panel.php') {
    $MOD = ['titulo'];
    $AC['titulo'] = strtolower($AC['titulo']) != 'undefined' ? $AC['titulo'] : Language('admin-panel');
}