<?php if (isset($_GET['tema']) && !empty($_GET['tema'])) {
	if(file_exists($Web["directorio"] . 'database/theme/' . $_GET['tema'])):
		$Web['theme']['styles'] = Daamper::$data->Read('theme/' . Daamper::$scripts->normalizar($_GET['tema']));
		if(!empty($Web['theme']['styles'])): ?>
		<section class="form flex-between" style="margin-top: 0px; margin-bottom: 0;">
			<a href="?ap=theme&tema=<?= Daamper::$scripts->normalizar($_GET['tema']) ?>&accion=Utilizar" class="boton"><?= Language('use') ?></a>
			<a href="?ap=theme&tema=<?= Daamper::$scripts->normalizar($_GET['tema']) ?>&accion=Normalizar" class="boton"><?= Language('normalize') ?></a>
			<a href="?ap=theme&tema=<?= Daamper::$scripts->normalizar($_GET['tema']) ?>&accion=Eliminar" class="boton2"><?= Language('delete') ?></a>
		</section>
		<?php endif; ?>
	<?php endif; if (isset($_GET['accion'])) { global $archivo_tema_confirmar; } ?>
	<?= isset($_GET['accion']) && in_array($_GET['accion'], ['eliminar', 'normalizar', 'utilizar']) ?
		'<section class="form" style="text-align: center; margin-top: 0; margin-bottom: 0; color: white; background-color: '. ($archivo_tema_confirmar ? 'green' : 'red') .';"><p>' . (
			$archivo_tema_confirmar ? (
				$_GET['accion'] == 'eliminar' ? Language('file-delete', 'global', ['value' => Daamper::$scripts->normalizar($_GET['tema'])]) :
					($_GET['accion'] == 'normalizar' ? Language(['theme', 'default-theme'], 'dashboard') : Language(['theme', 'theme-activated'], 'dashboard'))
			) : ($_GET['accion'] == 'eliminar' ? Language('file-no-deleted') :
					($_GET['accion'] == 'normalizar' ? Language(['theme', 'default-theme-off'], 'dashboard') : Language(['theme', 'theme-no-activated'], 'dashboard'))
		)) . '</p></section>' : '' ?>
<?php } ?>