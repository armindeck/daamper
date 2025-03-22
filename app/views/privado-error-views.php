<?php
if(
	isset($AX['privado']) && !empty($AX['privado']) && !isset($Web['ruta_borrador']) ||
	$Web['ruta_completa'] == './error.php' && !isset($Web['ruta_borrador'])):
	global $AXR, $AX, $Web;
	if($Web['ruta_completa'] != './error.php'){ $AX['titulo']='Directorio privado'; }
?>
<body>
	<div class="contenedor-privado">
		<div class="contenido">
			<div class="imagen" style="background: url('<?= $Web['config']['https_imagen'].AssetsImg('error.png') ?>');"></div>
			<h2 style="text-transform: uppercase; opacity: .8;"><?=
				isset($_GET['e']) ? 'Error ' . SCRIPTS->normalizar2($_GET['e']) : 'Directorio privado.';
			?></h2>
			<p style="padding: 4px;"><?= $AX['contenido'] ?></p>
			<div><a class="boton" href="<?= $Web['directorio'] ?>"><i class="fas fa-undo"></i> Volver</a></div>
		</div>
	</div>
</body>
</html>
<?php exit; endif; ?>