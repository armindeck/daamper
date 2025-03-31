<?php
$Web['directorio']='../../'; $Web['ruta']='panel/procesa/procesa.creador.borrador.php';
require $Web['directorio'].'app/control/control_procesa.php';
if (isset($_SESSION['creador-key-hidden']) && !isset($_SESSION['tmpForm'])) {
	$_SESSION['tmpForm'] = $_SESSION['creador-key-hidden'];
}
if(!isset($_SESSION['tmpForm'])){
	/* Error generado por: views/main */
	mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=> Language("no-access-preview", "alert"),'ruta'=>'../panel.php?ap=creador']);
}
if(!isset($_SESSION['tmpForm']['creador'])){
	mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=> Language("creator-not-exist", "alert"),'ruta'=>'../panel.php?ap=creador']);
}
unset($_SESSION['tmpForm']['mostrar']);
$X['creador_borrador_version'] = VERSION['dashboard']['creador']['preview']['version'] . ' ' . VERSION['dashboard']['creador']['preview']['state'];
$X['creador_borrador_fecha'] = VERSION['dashboard']['creador']['preview']['updated'];

/* VARIABLES LIBRES
	*	$ACR_CARGADO
	*	$AC_CARGA
	*	$LISTA_ACR
	*	...
*/

if(!file_exists('../app/creador/borradores/')){ if(mkdir('../app/creador/borradores/', 0777, true)); }

$LISTA_ACR = ['creador', 'pubo', 'db_archivo'];

foreach ($LISTA_ACR as $key => $value) {
	if(isset($_SESSION['tmpForm'][$value])){
		$ACR_FORM[$value] = SCRIPTS->normalizar2($_SESSION['tmpForm'][$value]);
	}
}

$ACR_VOLVER_A_MOSTRAR = isset($_SESSION['tmpForm']['volver_a_mostrarlo_como_nuevo']) &&
	!empty($_SESSION['tmpForm']['volver_a_mostrarlo_como_nuevo']) ? true : false;
$QUITARLO_DEL_INDEX = isset($_SESSION['tmpForm']['quitarlo_del_index']) &&
	!empty($_SESSION['tmpForm']['quitarlo_del_index']) ? true : false;

if(!empty($ACR_FORM['pubo'])){
	if(!in_array($ACR_FORM['pubo'], ['', 'borrador', 'publicacion'])){
		mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=> Language("do-not-modify-pubo", "alert"),'ruta'=>"../panel.php?ap=creador&creador={$ACR_FORM['creador']}"]);
	}
	$ruta_archivo = $Web['directorio'] . ($ACR_FORM['pubo'] == 'borrador' ? 'panel/app/creador/borradores/' :
			($ACR_FORM['pubo'] == 'publicacion' ? 'app/database/publicaciones/' : '')
		) . $ACR_FORM['db_archivo'];
	if(!file_exists($ruta_archivo)) {
		mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=>
			Language("file-not-exist", "alert", ['value' => $ACR_FORM['db_archivo']]),
			'ruta'=>"../panel.php?ap=creador&creador={$ACR_FORM['creador']}"]);
	}
	require $ruta_archivo;
	$ACR_CARGA = $ACR; $AC_CARGA = $AC;
	unset($ACR); unset($AC);
}

if(isset($ACR_CARGA)){
	foreach ($LISTA_ACR as $key => $value) {
		if($ACR_FORM[$value] != $ACR_CARGA[$value]){
			mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=> Language("data-different-hidden-fields", "alert"),'ruta'=>"../panel.php?ap=creador&creador={$ACR_CARGA['creador']}&tipo={$ACR_CARGA['tipo']}&archivo={$ACR['db_archivo']}"]);
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
		$AC_FORM[$key] = trim(SCRIPTS->quitarComilla($value));
	}
}

if(file_exists($Web['directorio'].'panel/app/creador/creadores/'.$ACR_FORM['creador'].'/post.php')){
	$ACR_CREADOR = $ACR_FORM; $AC_FORMULARIO = $AC_FORM;
	require $Web['directorio'].'panel/app/creador/creadores/'.$ACR_FORM['creador'].'/post.php';
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
	mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=> Language("missing-path-or-file", "alert"),'ruta'=>"../panel.php?ap=creador&creador={$ACR_FORM['creador']}"]);
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
$AC_FORM['archivo'] = SCRIPTS->archivoAceptado($AC_FORM['archivo']);
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

$AC_FORM['ruta'] = SCRIPTS->RutaConvertir($AC_FORM['ruta']);

$CONVERTIDO = [
	'ruta' => $AC_FORM['ruta'],
	'archivo' => $AC_FORM['archivo'],
	'ruta_archivo' => $AC_FORM['ruta'].$AC_FORM['archivo'],
	'ruta_archivo_slash' => str_replace('/', '-', $AC_FORM['ruta'].$AC_FORM['archivo']),
];

if(empty($ACR_FORM['pubo'])){
	if(
		file_exists($Web['directorio'].'app/database/publicaciones/pu_'.$CONVERTIDO['ruta_archivo_slash']) ||
		file_exists($Web['directorio'].'panel/app/creador/borradores/bo_'.$CONVERTIDO['ruta_archivo_slash'])
	){
		mensajeSpan(['bg'=>'red','text'=> Language("duplicate-post-or-draft", "alert"),'ruta'=>"../panel.php?ap=creador&creador={$ACR_FORM['creador']}"]);
	}
}

if(isset($ACR_CARGADO['db_ruta'])){
	if($CONVERTIDO['ruta_archivo'] != $ACR_CARGADO['db_ruta']){
		$_SESSION['tmpForm']['ruta'] = $AC_CARGA['ruta'];
		$_SESSION['tmpForm']['archivo'] = $AC_CARGA['archivo'];
		mensajeSpan(['bg'=>'red','text'=> Language("do-not-modify-path", "alert"),'ruta'=>"../panel.php?ap=creador&creador={$ACR_FORM['creador']}&tipo={$ACR_CARGADO['pubo']}&archivo={$ACR_FORM['db_archivo']}"]);
	}
}

if(!isset($_POST['guardar']) && !isset($_POST['publicar']) && !isset($_POST['eliminar'])):

require $Web['directorio'].AppContent('content.procesa.creador.borrador');
require $Web['directorio'].AppDatabase();
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
		<a class="boton" href="../panel.php?ap=creador"><?= Language("cancel") ?></a>
		<a class="boton" href="<?php echo '../panel.php?ap=creador&creador='.$ACR_FORM['creador'];
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
			echo '<b>'.$key .':</b> '.SCRIPTS->normalizar($value).'<hr> ';
		}
		if(isset($AC_FORM_POST)){
			echo '<h3>'.Language("POST-FORM", "other").'</h3><hr>';
			foreach ($AC_FORM_POST as $key => $value) {
				echo '<b>'.$key .':</b> '.SCRIPTS->normalizar($value).'<hr> ';
			}
		}
		if(file_exists($Web['directorio'].'panel/app/creador/creadores/'.$ACR_FORM['creador'].'/mod.php')){
			$ACR = $ACR_FORM; $AC = $AC_FORM;
			require $Web['directorio'].'panel/app/creador/creadores/'.$ACR_FORM['creador'].'/mod.php';
			if(isset($MOD)){
				echo '<h3>'.Language("CREATOR-MOD", "other").'</h3><hr>';
				foreach ($MOD as $key => $value) {
					echo '<b>'.$value .':</b> '.SCRIPTS->normalizar($AC[$value]).'<hr> ';
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
			echo '<b>'.$key .':</b> '.SCRIPTS->normalizar($value).'<hr> ';
		}
		if(isset($ACR_CARGADO)){
			echo '<h3>'.Language("LOADED", "other").'</h3><hr>';
			foreach ($ACR_CARGADO as $key => $value) {
				if($key!='id_publicador'){
					echo '<b>'.$key .':</b> '.SCRIPTS->normalizar($value).'<hr> ';
				}
			}
		}
	?></div>
</div>
<?php endif; ?>
<?php function Historial($Web, $texto){
	if(!file_exists($Web['directorio'].'panel/app/creador/historial.txt')){
		file_put_contents($Web['directorio'].'panel/app/creador/historial.txt','');
	}
	$leer_historial = file_get_contents($Web['directorio'].'panel/app/creador/historial.txt');
	if(strlen($leer_historial) > 0){ $leer_historial = "\n".$leer_historial; }
	$guardar_historial = SCRIPTS->fecha_hora().' ~ '.$texto.' -> '.$_SESSION['id'];
	file_put_contents($Web['directorio'].'panel/app/creador/historial.txt', $guardar_historial.$leer_historial);
} ?>
<?php if(isset($_POST['guardar']) && !empty($_POST['guardar']) || isset($_POST['publicar']) && !empty($_POST['publicar'])){
	$guardar = "<?php #". SCRIPTS->fecha_hora()."\n";
	$guardar .= '$ACR = [';
	if(empty($ACR_FORM['db_archivo']) || isset($_POST['guardar'])){
		$ACR_FORM['pubo'] = 'borrador';
		$ACR_FORM['db_archivo'] = 'bo_' . $CONVERTIDO['ruta_archivo_slash'];
	}
	if(isset($ACR_CARGADO['db_ruta'])){
		$ACR_FORM['db_ruta'] = $ACR_CARGADO['db_ruta'];
	} else {
		$ACR_FORM['db_ruta'] = $CONVERTIDO['ruta_archivo'];
	}
	if(isset($_POST['publicar'])){
		$ACR_FORM['pubo'] = 'publicacion';
		$ACR_FORM['db_archivo'] = 'pu_' . $CONVERTIDO['ruta_archivo_slash'];
	}
	if(!isset($ACR_CARGADO['fecha_publicado'])){
		$ACR_FORM['fecha_publicado'] = SCRIPTS->fecha_hora();
	} else {
		$ACR_FORM['fecha_publicado'] = $ACR_CARGADO['fecha_publicado'];
	}
	$ACR_FORM['fecha_modificado'] = SCRIPTS->fecha_hora();
	if(!isset($ACR_CARGADO['id_publicador'])){
		$ACR_FORM['id_publicador'] = $_SESSION['id'];
	} else {
		$ACR_FORM['id_publicador'] = $ACR_CARGADO['id_publicador'];
	}
	$ACR_FORM['creador_borrador_version'] = $X['creador_borrador_version'];
	$ACR_FORM['creador_borrador_fecha'] = $X['creador_borrador_fecha'];
	
	foreach ($ACR_FORM as $key => $value) {
		$guardar .= "'$key' => '".SCRIPTS->quitarComilla($value)."', ";
	}
	$guardar .= "];\n";
	$guardar .= '$AC = [';
	foreach ($AC_FORM as $key => $value) {
		if (!in_array($key, ['volver_a_mostrarlo_como_nuevo', 'mostrar_en_index', 'quitarlo_del_index'])) {
			$guardar .= "'$key' => '".SCRIPTS->quitarComilla($value)."', ";
		}
	}
	$guardar .= "];\n?>";

	if(isset($_POST['guardar'])){
		file_put_contents($Web['directorio'].'panel/app/creador/borradores/'.$ACR_FORM['db_archivo'], $guardar);
		Historial($Web, 'Guardar/Actualizar: '.$ACR_FORM['db_archivo']);
		mensajeSpan(['bg'=>'green','text'=> Language("draft-saved", "alert", ["value" => "<b>".$ACR_FORM['db_archivo']."</b>"]),'ruta'=>"../panel.php?ap=creador"]);
	} elseif(isset($_POST['publicar'])){
		$mostrar_en_index = true;
		if(file_exists($Web['directorio'].'app/database/publicaciones/'.$ACR_FORM['db_archivo']) && !$ACR_VOLVER_A_MOSTRAR){
			$mostrar_en_index = false;
		} else {
			$mostrar_en_index = isset($AC_FORM['mostrar_en_index']) && !empty($AC_FORM['mostrar_en_index']) ? true : false;
		}

		function AgregarEntradas (string $archivo_publicaciones = 'publicaciones.php') { global $Web, $mostrar_en_index, $ACR_VOLVER_A_MOSTRAR, $QUITARLO_DEL_INDEX, $CONVERTIDO;
			$archivo_publicaciones = $Web['directorio'] . 'app/database/publicaciones/' . $archivo_publicaciones;
			if(!file_exists($archivo_publicaciones)){
				file_put_contents($archivo_publicaciones, '<?php return []; ?>');
			}

			$archivo_publicaciones_dato = file_get_contents($archivo_publicaciones);
			
			if($mostrar_en_index || $ACR_VOLVER_A_MOSTRAR){
				$archivo_publicaciones_dato = str_replace([']; ?>', '];?>'], '', $archivo_publicaciones_dato);
			}
			#MOSTRAR EN INDEX Y MOSTRAR DE NUEVO
			if(!file_exists($Web['directorio'].'app/database/publicaciones/'.$ACR_FORM['db_archivo']) ||
				$ACR_VOLVER_A_MOSTRAR || $QUITARLO_DEL_INDEX
			){
				$archivo_publicaciones_dato = str_replace("'{$CONVERTIDO['ruta_archivo_slash']}',", '', $archivo_publicaciones_dato);
			}

			if($mostrar_en_index || $ACR_VOLVER_A_MOSTRAR){
				$archivo_publicaciones_dato .= "'{$CONVERTIDO['ruta_archivo_slash']}',]; ?>";
			}
			
			file_put_contents($archivo_publicaciones, $archivo_publicaciones_dato);
		}
		$EXTRA['ruta_simple'] = trim($AC_FORM['ruta'], '/');
		if (in_array($EXTRA['ruta_simple'], ['anime', 'hentai', 'ver', 'pelicula', 'movie', 'juego', 'game', 'aplicacion', 'aplication', 'blog', 'post', 'actualizacion', 'update', 'web'])) {
			AgregarEntradas('publicaciones-'. 
				(in_array($EXTRA['ruta_simple'], ['pelicula', 'movie']) ? 'pelicula' : 
				(in_array($EXTRA['ruta_simple'], ['juego', 'game']) ? 'juego' : 
				(in_array($EXTRA['ruta_simple'], ['aplicacion', 'aplication']) ? 'aplicacion' :
				(in_array($EXTRA['ruta_simple'], ['actualizacion', 'update']) ? 'actualizacion' :
					$EXTRA['ruta_simple']
				))))
				.'.php');
		} else {
			AgregarEntradas();
		}

		$guardar_archivo = "<?php #".SCRIPTS->fecha_hora()."\n";
		$guardar_archivo .= '$Web'." = ['directorio'=>'{$AC_FORM['directorio']}','ruta'=>'{$CONVERTIDO['ruta_archivo']}'];\n";
		$guardar_archivo .= 'require_once "{$Web["directorio"]}app/control/control.php";'."\n";
		$guardar_archivo .= '?>';

		if(mkdir($Web['directorio'].$CONVERTIDO['ruta'], 0777, true));

		file_put_contents($Web['directorio'].$CONVERTIDO['ruta_archivo'], $guardar_archivo);
		file_put_contents($Web['directorio'].'app/database/publicaciones/'.$ACR_FORM['db_archivo'], $guardar);
		unlink($Web['directorio'].'panel/app/creador/borradores/bo_'. $CONVERTIDO['ruta_archivo_slash']);
		Historial($Web, 'Publicar/Actualizar: '.$ACR_FORM['db_archivo']);
		mensajeSpan(['bg'=>'green','text'=> Language("new-post-published", "alert", ["value" => '<a href="../'.$CONVERTIDO['ruta_archivo'].'" target="_blank"><b>'.Language('show').' <i class="fas fa-external-link-alt"></i></b></a>']),'ruta'=>"../panel.php?ap=creador"]);
	}
	exit;
}

if(isset($_POST['eliminar']) && !empty($_POST['eliminar'])){
	if($ACR_FORM['pubo'] == 'borrador'){
		unlink($Web['directorio'].'panel/app/creador/borradores/'.$ACR_FORM['db_archivo']);
		Historial($Web, 'Eliminar ~ borrador: '.$ACR_FORM['db_archivo']);
		mensajeSpan(['bg'=>'green','text'=> Language("draft-deleted", "alert", ["value" => "<b>".$ACR_FORM['db_archivo']."</b>"]),'ruta'=>"../panel.php?ap=creador"]);
	}

	if($ACR_FORM['pubo'] == 'publicacion'){
		unlink($Web['directorio'].'app/database/publicaciones/'.$ACR_FORM['db_archivo']);
		unlink($Web['directorio'].$AC_FORM['ruta'].$AC_FORM['archivo']);

		$archivo_publicaciones = $Web['directorio'].AppDatabase('publicaciones/publicaciones');
		$archivo_publicaciones_dato = file_get_contents($archivo_publicaciones);
		$archivo_publicaciones_dato = str_replace("'{$CONVERTIDO['ruta_archivo_slash']}',", '', $archivo_publicaciones_dato);
		file_put_contents($archivo_publicaciones, $archivo_publicaciones_dato);

		Historial($Web, 'Eliminar ~ Publicación: '.$ACR_FORM['db_archivo']);

		mensajeSpan(['bg'=>'green','text'=> Language("post-deleted", "alert", ["value" => "<b>".$ACR_FORM['db_archivo']."</b>"]),'ruta'=>"../panel.php?ap=creador"]);
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
require $Web['directorio'].AppViews();
endif;
?>