<?php
$guardar = "<?php #". SCRIPTS->xv('plantilla', null, true);
$guardar .= "\nreturn [\n";

foreach ($_POST as $key => $value) {
	if (!empty($value) && !in_array($key, $lista_post_oficial)) {
		$guardar .= "'" . SCRIPTS->normalizar2($key) . "' => '" . trim(SCRIPTS->quitarComilla($value)) . "',\n";
	}
}

$guardar .= "];\n?>";

file_put_contents(__DIR__.'/web-plantilla-scripts.php', $guardar);
if ($archivo_plantilla) {
	file_put_contents(__DIR__."/plantillas/scr-{$archivo_plantilla}", $guardar);
}
?>