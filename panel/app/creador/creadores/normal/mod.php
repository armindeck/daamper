<?php
if ($AC['ruta'].$AC['archivo'] == 'error.php') {
    $MOD = ['titulo'];
    $AC['titulo'] = strtolower($AC['titulo']) != 'undefined' ? $AC['titulo'] : Language(['error', 'title'], 'posts');
}
if ($AC['ruta'].$AC['archivo'] == 'panel/panel.php') {
    $MOD = ['titulo'];
    $AC['titulo'] = strtolower($AC['titulo']) != 'undefined' ? $AC['titulo'] : Language('admin-panel');
}