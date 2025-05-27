<?php
$post = [];
foreach ($_POST as $key => $value) {
	if (!empty($value) && !in_array($key, $lista_post_oficial)) {
		$post[SCRIPTS->normalizar2($key)] = trim(SCRIPTS->quitarComilla($value));
	}
}
DATA->Save("template/scr-template", $post);
if ($archivo_plantilla) {
	DATA->Save("template/scr-$archivo_plantilla", $post);
}
