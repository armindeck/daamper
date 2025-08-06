<?php
$post = [];
foreach ($_POST as $key => $value) {
	if (!empty($value) && !in_array($key, $lista_post_oficial)) {
		$post[Daamper::$scripts->normalizar2($key)] = trim(Daamper::$scripts->quitarComilla($value));
	}
}
Daamper::$data->Save("template/scr-template", $post);
if ($archivo_plantilla) {
	Daamper::$data->Save("template/scr-$archivo_plantilla", $post);
}
