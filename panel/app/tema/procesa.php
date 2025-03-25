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

$guardar = "<?php\n".'$Web['."'tema'"."]['styles']=[\n";
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
if(!mkdir("../app/$Apartado/temas/", 0777, true));
$confirmar = file_put_contents("../app/$Apartado/temas/" . $post['archivo'], $guardar);

if($confirmar){
	mensajeSpan(['bg'=>'green','text'=>Language('data-save'),'ruta'=>"../panel.php?ap=$Apartado&tema={$post['archivo']}"]);
} else {
	mensajeSpan(['bg'=>'red','text'=>Language('data-no-save'),'ruta'=>"../panel.php?ap=$Apartado&tema={$post['archivo']}"]);
}

$DATOS_DEFAULT = false;
?>