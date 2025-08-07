<?php if(isset($AX['privado']) && !empty($AX['privado']) && !isset($Web['ruta_borrador']) ||
	$Web['ruta_completa'] == './error.php' && !isset($Web['ruta_borrador'])):
	global $AX, $Web;
?>
<body>
	<div class="contenedor-privado">
		<div class="contenido">
			<div class="imagen" style="background: url('<?= $Web['config']['https_imagen'].Daamper::imgPath('error.png') ?>');"></div>
			<h2 style="text-transform: uppercase; opacity: .8;"><?= Language(['htaccess', isset($_GET['e']) ? Daamper::$scripts->normalizar2($_GET['e']) : 404], 'dashboard') ?></h2>
			<p style="padding: 4px;"><?= isset($AX['contenido']) && !empty($AX['contenido']) ? $AX['contenido'] : Language(['error', 'page-not-available'], 'posts') ?></p>
			<div><a class="boton" href="<?= $Web['directorio'] ?>"><i class="fas fa-home"></i> <?= Language('home') ?></a></div>
		</div>
	</div>
</body>
</html>
<?php exit; endif; ?>