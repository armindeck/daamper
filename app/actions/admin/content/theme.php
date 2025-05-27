<?php
$post = [];
$post['nombre_tema'] = SCRIPTS->normalizar($_POST["nombre_tema"]);
$post['archivo'] = SCRIPTS->archivoAceptado($_POST["archivo"]);
$post['cantidad'] = isset($_POST['cantidad']) && !empty($_POST['cantidad']) ? SCRIPTS->normalizar($_POST['cantidad']) : 1;
$lista_post = ['titulo','id','id_hidden','class','bg','co','br','pd','mr'];
for ($i=0; $i < $post['cantidad']; $i++) {
	foreach ($lista_post as $key => $value) {
		$post["{$value}_{$i}"] = isset($_POST["{$value}_{$i}"]) ? SCRIPTS->normalizar($_POST["{$value}_{$i}"]) : '';
	}
	$post["otros_{$i}"] = isset($_POST["otros_{$i}"]) ? SCRIPTS->quitarComilla($_POST["otros_{$i}"]) : '';
}
$post["archivo"] = str_replace([".php", ".json"], "", $post["archivo"]) . ".json";
$guardar = "<?php\n return [\n";
$guardar .= "'nombre_tema'=>'{$post['nombre_tema']}',\n";
$guardar .= "'archivo'=>'{$post['archivo']}',\n";
$guardar .= "'cantidad'=>'{$post['cantidad']}',\n";

for ($i=0; $i < $post['cantidad']; $i++) {
	if ($post['id_'.$i] == ''){
		$post['id_'.$i] = $post['cantidad'];
	}

	$guardar .= $post['id_'.$i] . " => [";
	foreach ($lista_post as $key => $value) {
		$guardar .= "'$value' => '" . $post["{$value}_{$i}"] . "',";
	}
	$guardar .= "'otros'=>'".$post["otros_{$i}"]."',";
	$guardar .= "],\n";
}

$guardar .= "];\n?>";
SCRIPTS->CrearCarpetas("database/temp/");
file_put_contents($Web["directorio"] . "database/temp/" . str_replace(".json", ".php", $post['archivo']), $guardar);
$leer = require $Web["directorio"] . "database/temp/" . str_replace(".json", ".php", $post['archivo']);
SCRIPTS->CrearCarpetas("database/$Apartado/");
$confirmar = DATA->Save("$Apartado/{$post['archivo']}", $leer);
unlink($Web["directorio"] . "database/temp/" . str_replace(".json", ".php", $post['archivo']));

if(!$confirmar){
	sendAlert->Error(Language('data-no-save'), "../admin.php?ap=$Apartado&tema={$post['archivo']}");
}

sendAlert->Success(Language('data-save'), "../admin.php?ap=$Apartado&tema={$post['archivo']}");

$DATOS_DEFAULT = false;