<?php
$Web=['directorio'=>'../../','ruta'=>'admin/process/creator.php'];
require_once $Web['directorio'].'app/controller/admin.php';
if (isset($_SESSION['creador-key-hidden']) && !isset($_SESSION['tmpForm'])) {
	$_SESSION['tmpForm'] = $_SESSION['creador-key-hidden'];
}
if(!isset($_SESSION['tmpForm'])){
	/* Error generado por: views/main */
	Daamper::$sendAlert->Warning(Language("no-access-preview", "alert"), '../admin.php?ap=creator&disable-entries=true');
}
if(!isset($_SESSION['tmpForm']['creador'])){
	Daamper::$sendAlert->Warning(Language("creator-not-exist", "alert"), '../admin.php?ap=creator&disable-entries=true');
}
unset($_SESSION['tmpForm']['mostrar']);
$X['creador_borrador_version'] = Daamper::$version['dashboard']['creator']['preview']['version'] . ' ' . Daamper::$version['dashboard']['creator']['preview']['state'];
$X['creador_borrador_fecha'] = Daamper::$version['dashboard']['creator']['preview']['updated'];

/* VARIABLES LIBRES
	*	$ACR_CARGADO
	*	$AC_CARGA
	*	$LISTA_ACR
	*	...
*/

if(!file_exists('../../database/draft/')){ if(mkdir('../../database/draft/', 0777, true)); }

$LISTA_ACR = ['creador', 'pubo', 'db_archivo'];

foreach ($LISTA_ACR as $key => $value) {
	if(isset($_SESSION['tmpForm'][$value])){
		$ACR_FORM[$value] = Daamper::$scripts->normalizar2($_SESSION['tmpForm'][$value]);
	}
}

$ACR_VOLVER_A_MOSTRAR = isset($_SESSION['tmpForm']['volver_a_mostrarlo_como_nuevo']) &&
	!empty($_SESSION['tmpForm']['volver_a_mostrarlo_como_nuevo']) ? true : false;
$QUITARLO_DEL_INDEX = isset($_SESSION['tmpForm']['quitarlo_del_index']) &&
	!empty($_SESSION['tmpForm']['quitarlo_del_index']) ? true : false;

if(!empty($ACR_FORM['pubo'])){
	if(!in_array($ACR_FORM['pubo'], ['', 'borrador', 'publicacion'])){
		Daamper::$sendAlert->Warning(Language("do-not-modify-pubo", "alert"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}");
	}
	$post_or_draft = match (true) {
		$ACR_FORM['pubo'] == "borrador" => "draft",
		$ACR_FORM['pubo'] == "publicacion" => "post",
		default => $ACR_FORM['pubo']
	};
	$archivo_en_db = str_replace(["pu_", "bo_", ".php", ".json"], "", $ACR_FORM['db_archivo']) . ".json";
	$ruta_archivo = $Web["directorio"] . "database/" . $post_or_draft . "/" . $archivo_en_db;
	
	if(!file_exists($ruta_archivo)) {
		Daamper::$sendAlert->Warning(Language("file-not-exist", "alert", ['value' => $ACR_FORM['db_archivo']]),
			"../admin.php?ap=creator&mensaje=es-true&creador={$ACR_FORM['creador']}"
		);
	}
	
	$ACR_CARGA = Daamper::$data->Read($post_or_draft . "/" . $archivo_en_db)["ACR"];
	$AC_CARGA = Daamper::$data->Read($post_or_draft . "/" . $archivo_en_db)["AC"];
}

if(isset($ACR_CARGA)){
	foreach ($LISTA_ACR as $key => $value) {
		if($ACR_FORM[$value] != $ACR_CARGA[$value]){
			Daamper::$sendAlert->Warning(Language("data-different-hidden-fields", "alert"), "../admin.php?ap=creator&creador={$ACR_CARGA['creador']}&tipo={$ACR_CARGA['tipo']}&archivo={$ACR['db_archivo']}");
		}
	}
	$LISTA_ACR_CARGA = ['creador','pubo','db_ruta','id_publicador','fecha_publicado','fecha_modificado','creador_borrador_version','creador_borrador_fecha'];
	foreach ($LISTA_ACR_CARGA as $key => $value) {
		if(in_array($value, ['creador_borrador_version','creador_borrador_fecha']) && !isset($ACR_CARGA[$value])){
			$ACR_CARGA[$value] = $X[$value];
		}
		$ACR_CARGADO[$value] = $ACR_CARGA[$value];
	}
	unset($ACR_CARGA); unset($LISTA_ACR_CARGA);
}

foreach ($_SESSION['tmpForm'] as $key => $value) {
	if(!in_array($key, ['creador', 'pubo', 'db_ruta', 'db_archivo', 'volver_a_mostrarlo_como_nuevo', 'quitarlo_del_index'])){
		$AC_FORM[$key] = trim(Daamper::$scripts->quitarComilla($value));
	}
}

if(file_exists(RAIZ . 'app/actions/admin/content/global/creators/action/'.$ACR_FORM['creador'].'.php')){
	$ACR_CREADOR = $ACR_FORM; $AC_FORMULARIO = $AC_FORM;
	require RAIZ . 'app/actions/admin/content/global/creators/action/'.$ACR_FORM['creador'].'.php';
	if(isset($AC_FORM_POST)){
		foreach ($AC_FORM_POST as $key => $value) {
			$AC_FORM[$key] = $value;
			$AX[$key] = $value;
		}
	}
	unset($ACR_CREADOR); unset($AC_FORMULARIO);
	unset($ACR); unset($AC); unset($Post);
}

if (isset($AC_FORM['ruta'])) { $AC_FORM['ruta'] = str_replace(['../','./'], '', $AC_FORM['ruta']); $AC_FORM['ruta'] = trim($AC_FORM['ruta'], '/'); }

if(!isset($AC_FORM['ruta']) || !isset($AC_FORM['archivo'])){
	Daamper::$sendAlert->Warning(Language("missing-path-or-file", "alert"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}");
}

if (empty($AC_FORM['ruta'])) {
	$AC_FORM['directorio'] = './';
} else {
	$AC_FORM['directorio'] = $AC_FORM['ruta'];
	$AC_FORM['directorio'] = explode('/', $AC_FORM['directorio']);
	$AC_FORM['directorio'] = count($AC_FORM['directorio']);
	$AC_FORM['directorio'] = str_repeat('../', $AC_FORM['directorio']);
}

$AC_FORM['archivo'] = str_replace('.php', '', $AC_FORM['archivo']);
$AC_FORM['archivo'] = Daamper::$scripts->archivoAceptado($AC_FORM['archivo']);
$AC_FORM['archivo'] .= '.php';

if(!empty($AC_FORM['ruta'])){ $pase=false;
	$RUT_SLAS = $AC_FORM['ruta'];
	if(strlen($AC_FORM['ruta']) > 1){
 		if($RUT_SLAS[-1] != '/'){ $pase = true; }
	}
	if(strlen($AC_FORM['ruta']) == 1){ $pase = true; }

	if($pase){
		$AC_FORM['ruta'] = $AC_FORM['ruta'].'/';
	}
	unset($pase); unset($RUT_SLAS);
}

$AC_FORM['ruta'] = Daamper::$scripts->RutaConvertir($AC_FORM['ruta']);

$CONVERTIDO = [
	'ruta' => $AC_FORM['ruta'],
	'archivo' => $AC_FORM['archivo'],
	'ruta_archivo' => $AC_FORM['ruta'].$AC_FORM['archivo'],
	'ruta_archivo_slash' => str_replace('/', '-', $AC_FORM['ruta'].$AC_FORM['archivo'])
];

$CONVERTIDO['ruta_archivo_slash_json'] = str_replace([".php", ".json"], "", $CONVERTIDO['ruta_archivo_slash']) . ".json";
$FILE_JSON_DATA = $CONVERTIDO['ruta_archivo_slash_json'];

$default = Daamper::$data->Config("admin")["creator"]["publish"];
if(in_array(str_replace(".php", "", $CONVERTIDO["ruta_archivo"]), $default["access"]["files"]) && !in_array(strtolower($_SESSION["rol"]), $default["access"]["rules"])){
	Daamper::$sendAlert->Error(Language(["creator", "need-higher-role-to-modify-post"], "dashboard"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}");
}

if(in_array(trim($CONVERTIDO["ruta"], "/"), $default["denied-routes"])){
	if(trim($CONVERTIDO["ruta"], "/") == "p" && strtolower($_SESSION["rol"]) != "ceo founder" || trim($CONVERTIDO["ruta"], "/") != "p"){
		Daamper::$sendAlert->Error(Language(["creator", "please-use-another-route"], "dashboard"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}");
	}
}

if(empty($ACR_FORM['pubo'])){
	if(
		file_exists(RAIZ . 'database/post/'.$CONVERTIDO['ruta_archivo_slash']) ||
		file_exists(RAIZ . 'database/draft/'.$CONVERTIDO['ruta_archivo_slash'])
	){
		Daamper::$sendAlert->Error(Language("duplicate-post-or-draft", "alert"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}");
	}
}

if(isset($ACR_CARGADO['db_ruta'])){
	if($CONVERTIDO['ruta_archivo'] != $ACR_CARGADO['db_ruta']){
		$_SESSION['tmpForm']['ruta'] = $AC_CARGA['ruta'];
		$_SESSION['tmpForm']['archivo'] = $AC_CARGA['archivo'];
		Daamper::$sendAlert->Error(Language("do-not-modify-path", "alert"), "../admin.php?ap=creator&creador={$ACR_FORM['creador']}&tipo={$ACR_CARGADO['pubo']}&archivo={$ACR_FORM['db_archivo']}");
	}
}

if(!isset($_POST['guardar']) && !isset($_POST['publicar']) && !isset($_POST['eliminar'])):

require RAIZ . Daamper::contentPath("creator");
?>
<style type="text/css">
	.procesa-creador-borrador-header {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		align-items: center;
		padding: 16px 4px;
		color: white;
		background: #1d893a;
	}
	.procesa-creador-borrador-datos {
		display: flex;
		flex-wrap: wrap;
		flex-direction: column;
		padding: 8px;
		color: white;
		background: rgb(0,0,0,.4);
	}
	.procesa-creador-borrador-datos div {
		min-height: 150px;
		max-height: 150px;
		overflow: hidden;
		overflow-y: auto;
	}
</style>
<div class="procesa-creador-borrador-header">
	<p style="padding: 4px;"><b><?= Language("preview") ?></b> <span style="font-size: 10px;">v<?= $X['creador_borrador_version']; ?> ~ <?= $X['creador_borrador_fecha']; ?></span></p>
	<div>
		<a class="boton" href="../admin.php?ap=creator"><?= Language("cancel") ?></a>
		<a class="boton" href="<?php echo '../admin.php?ap=creator&creador='.$ACR_FORM['creador'];
			echo !empty($ACR_FORM['pubo']) ? '&tipo='.$ACR_FORM['pubo'].'&archivo='.$ACR_FORM['db_archivo'] : '';
		?>"><?= Language("go-back") ?></a>
		<form method="post" style="display: inline-block;">
			<input class="boton" style="padding: 10px;" type="submit" name="guardar" value="<?= Language("save") ?>">
		</form>
		<?php if(!empty($ACR_FORM['pubo'])): ?>
		<form method="post" style="display: inline-block;">
			<input class="boton2" style="padding: 10px;" type="submit" name="eliminar" value="<?= Language("delete") ?>">
		</form>
		<form method="post" style="display: inline-block;">
			<input class="boton" style="padding: 10px;" type="submit" name="publicar" value="<?= Language("publish") ?>">
		</form>
		<?php endif; ?>
	</div>
</div>
<div class="procesa-creador-borrador-datos">
	<b><?= Language("data") ?>:</b>
	<div class="campo scrolls" style="min-width: 100%; max-width: 100%;"><?php
		echo '<h3>'.Language("FORM", "other").'</h3><hr>';
		foreach ($AC_FORM as $key => $value) {
			echo '<b>'.$key .':</b> '.Daamper::$scripts->normalizar($value).'<hr> ';
		}
		if(isset($AC_FORM_POST)){
			echo '<h3>'.Language("POST-FORM", "other").'</h3><hr>';
			foreach ($AC_FORM_POST as $key => $value) {
				echo '<b>'.$key .':</b> '.Daamper::$scripts->normalizar($value).'<hr> ';
			}
		}
		if(file_exists(RAIZ . 'app/actions/admin/content/global/creators/mod/'.$ACR_FORM['creador'].'.php')){
			$ACR = $ACR_FORM; $AC = $AC_FORM;
			require RAIZ . 'app/actions/admin/content/global/creators/mod/'.$ACR_FORM['creador'].'.php';
			if(isset($MOD)){
				echo '<h3>'.Language("CREATOR-MOD", "other").'</h3><hr>';
				foreach ($MOD as $key => $value) {
					echo '<b>'.$value .':</b> '.Daamper::$scripts->normalizar($AC[$value]).'<hr> ';
				}
				if(isset($AC)){
					foreach ($AC as $key => $value) {
						$AX[$key] = $value;
					}
				}
			}
		}
		echo '<h3>'.Language("CREATOR", "other").'</h3><hr>';
		foreach ($ACR_FORM as $key => $value) {
			echo '<b>'.$key .':</b> '.Daamper::$scripts->normalizar($value).'<hr> ';
		}
		if(isset($ACR_CARGADO)){
			echo '<h3>'.Language("LOADED", "other").'</h3><hr>';
			foreach ($ACR_CARGADO as $key => $value) {
				if($key!='id_publicador'){
					echo '<b>'.$key .':</b> '.Daamper::$scripts->normalizar($value).'<hr> ';
				}
			}
		}
	?></div>
</div>
<?php endif; ?>
<?php function Historial($Web, $texto){
	$ruta_historial = "database/files/txt/history/";
	Daamper::$scripts->CrearCarpetas($ruta_historial);
	$ruta_historial = RAIZ . $ruta_historial . "creator.txt";
	if(!file_exists($ruta_historial)){ file_put_contents($ruta_historial,''); }
	$leer_historial = file_get_contents($ruta_historial);
	if(strlen($leer_historial) > 0){ $leer_historial = "\n".$leer_historial; }
	$guardar_historial = Daamper::$scripts->fecha_hora().' ~ '.$texto.' -> '.$_SESSION['id'];
	file_put_contents($ruta_historial, $guardar_historial.$leer_historial);
} ?>
<?php if(isset($_POST['guardar']) && !empty($_POST['guardar']) || isset($_POST['publicar']) && !empty($_POST['publicar'])){
	if(empty($ACR_FORM['db_archivo']) || isset($_POST['guardar'])){
		$ACR_FORM['pubo'] = 'borrador';
		$ACR_FORM['db_archivo'] = $FILE_JSON_DATA;
	}
	if(isset($ACR_CARGADO['db_ruta'])){
		$ACR_FORM['db_ruta'] = $ACR_CARGADO['db_ruta'];
	} else {
		$ACR_FORM['db_ruta'] = $CONVERTIDO['ruta_archivo'];
	}
	if(isset($_POST['publicar'])){
		$ACR_FORM['pubo'] = 'publicacion';
		$ACR_FORM['db_archivo'] = $FILE_JSON_DATA;
	}
	if(!isset($ACR_CARGADO['fecha_publicado'])){
		$ACR_FORM['fecha_publicado'] = Daamper::$scripts->fecha_hora();
	} else {
		$ACR_FORM['fecha_publicado'] = $ACR_CARGADO['fecha_publicado'];
	}
	$ACR_FORM['fecha_modificado'] = Daamper::$scripts->fecha_hora();
	if(!isset($ACR_CARGADO['id_publicador'])){
		$ACR_FORM['id_publicador'] = $_SESSION['id'];
	} else {
		$ACR_FORM['id_publicador'] = $ACR_CARGADO['id_publicador'];
	}
	$ACR_FORM['creador_borrador_version'] = $X['creador_borrador_version'];
	$ACR_FORM['creador_borrador_fecha'] = $X['creador_borrador_fecha'];
	
	$AC_FORM_GUARDAR = [];

	foreach ($AC_FORM as $key => $value) {
		if (!in_array($key, ['volver_a_mostrarlo_como_nuevo', 'mostrar_en_index', 'quitarlo_del_index'])) {
			$AC_FORM_GUARDAR[$key] = $value;
		}
	}

	$SAVE = ["ACR" => $ACR_FORM, "AC" => $AC_FORM_GUARDAR];

	if(isset($_POST['guardar'])){
		Daamper::$data->Save("draft/$FILE_JSON_DATA", $SAVE);
		Historial($Web, 'Guardar/Actualizar: '.$FILE_JSON_DATA);
		Daamper::$sendAlert->Success(Language("draft-saved", "alert", ["value" => "<b>".$FILE_JSON_DATA."</b>"]), "../admin.php?ap=creator&disable-entries=true");
	} elseif(isset($_POST['publicar'])){
		$mostrar_en_index = true;
		if(file_exists(RAIZ . "database/post/" . $FILE_JSON_DATA) && !$ACR_VOLVER_A_MOSTRAR){
			$mostrar_en_index = false;
		} else {
			$mostrar_en_index = isset($AC_FORM['mostrar_en_index']) && !empty($AC_FORM['mostrar_en_index']) ? true : false;
		}

		function AgregarEntradas (string $archivo_publicaciones = 'posts') { global $Web, $FILE_JSON_DATA, $mostrar_en_index, $ACR_VOLVER_A_MOSTRAR, $QUITARLO_DEL_INDEX, $CONVERTIDO;
			$archivo_publicaciones = str_replace(".php", "", $archivo_publicaciones) . ".json";
			$archivo_publicaciones = 'database/post/entries/' . $archivo_publicaciones;
			Daamper::$scripts->CrearCarpetas('database/post/entries/');
			if(!file_exists(RAIZ . $archivo_publicaciones)){
				Daamper::$data->Save($archivo_publicaciones, []);
			}

			$archivo_publicaciones_dato = Daamper::$data->Read($archivo_publicaciones);
			
			#MOSTRAR EN INDEX Y MOSTRAR DE NUEVO
			if(!file_exists(RAIZ . 'database/post/' . $FILE_JSON_DATA) ||
				$ACR_VOLVER_A_MOSTRAR || $QUITARLO_DEL_INDEX
			){
				foreach ($archivo_publicaciones_dato as $key => $value) {
					if($value == $CONVERTIDO['ruta_archivo_slash']){
						unset($archivo_publicaciones_dato[$key]);
					}
				}
			}

			if($mostrar_en_index || $ACR_VOLVER_A_MOSTRAR){
				$archivo_publicaciones_dato[] = $CONVERTIDO['ruta_archivo_slash'];
			}
			
			Daamper::$data->Save($archivo_publicaciones, $archivo_publicaciones_dato);
		}
		$EXTRA['ruta_simple'] = trim($AC_FORM['ruta'], '/');
		if (in_array($EXTRA['ruta_simple'], ['anime', 'hentai', 'ver', 'pelicula', 'movie', 'juego', 'game', 'aplicacion', 'aplication', 'blog', 'post', 'actualizacion', 'update', 'web'])) {
			AgregarEntradas( 
				(in_array($EXTRA['ruta_simple'], ['pelicula', 'movie']) ? 'pelicula' : 
				(in_array($EXTRA['ruta_simple'], ['juego', 'game']) ? 'juego' : 
				(in_array($EXTRA['ruta_simple'], ['aplicacion', 'aplication']) ? 'aplicacion' :
				(in_array($EXTRA['ruta_simple'], ['actualizacion', 'update']) ? 'actualizacion' :
					$EXTRA['ruta_simple']
				))))
			);
		} else {
			AgregarEntradas();
		}

		Daamper::$scripts->CrearCarpetas($CONVERTIDO['ruta']);
		Daamper::$scripts->CreateEntry($CONVERTIDO['ruta_archivo'], $AC_FORM["directorio"]);

		Daamper::$data->Save("post/$FILE_JSON_DATA", $SAVE);
		unlink(RAIZ . "database/draft/" . $FILE_JSON_DATA);
		Historial($Web, 'Publicar/Actualizar: '.$FILE_JSON_DATA);
		Daamper::$sendAlert->Success(Language("new-post-published", "alert", ["value" => '<a href="../'.$CONVERTIDO['ruta_archivo'].'" target="_blank"><b>'.Language('show').' <i class="fas fa-external-link-alt"></i></b></a>']), "../admin.php?ap=creator&disable-entries=true");
	}
	exit;
}

if(isset($_POST['eliminar']) && !empty($_POST['eliminar'])){
	if($ACR_FORM['pubo'] == 'borrador'){
		unlink(RAIZ . "database/draft/" . $FILE_JSON_DATA);
		Historial($Web, 'Eliminar ~ borrador: '.$FILE_JSON_DATA);
		Daamper::$sendAlert->Success(Language("draft-deleted", "alert", ["value" => "<b>".$FILE_JSON_DATA."</b>"]), "../admin.php?ap=creator&disable-entries=true");
	}

	if($ACR_FORM['pubo'] == 'publicacion'){
		unlink(RAIZ . "database/post/" . $FILE_JSON_DATA);
		unlink(RAIZ . $AC_FORM['ruta'].$AC_FORM['archivo']);

		$archivo_publicaciones = RAIZ . "database/post/entries/posts.json";
		$archivo_publicaciones_dato = Daamper::$data->Read("post/entries/posts.json") ?? [];
		unset($archivo_publicaciones_dato[$CONVERTIDO['ruta_archivo_slash']]);
		Daamper::$data->Save("post/entries/posts", $archivo_publicaciones_dato);

		Historial($Web, 'Eliminar ~ Publicación: '.$FILE_JSON_DATA);

		Daamper::$sendAlert->Success(Language("post-deleted", "alert", ["value" => "<b>".$FILE_JSON_DATA."</b>"]), "../admin.php?ap=creator&disable-entries=true");
	}
} ?>




<?php if(!isset($_POST['guardar']) && !isset($_POST['publicar']) && !isset($_POST['eliminar'])):

$Web['ruta_borrador'] = $AC_FORM['ruta'].$AC_FORM['archivo'];
if(!isset($ACR)){ $ACR = $ACR_FORM;}
if(!isset($AC)){ $AC = $AC_FORM;}

unset($ACR_FORM);
unset($AC_FORM);
unset($AC);
unset($ACR);
unset($AC_FORM_POST);
unset($ACR_CARGADO);
unset($AC_CARGA);
unset($LISTA_ACR);
$_SESSION['creador-key-hidden'] = $_SESSION['tmpForm'];
require RAIZ . Daamper::viewsPath();
endif;
?>