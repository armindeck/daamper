<?php if (isset($_GET['tema']) && !empty($_GET['tema'])) {
	if(file_exists(__DIR__ . '/temas/' . $_GET['tema'])):
		require __DIR__ . '/temas/'. SCRIPTS->normalizar($_GET['tema']);
		if(isset($Web['tema']['styles'])) :?>
		<section class="form flex-between" style="margin-top: 0px; margin-bottom: 0;">
			<a href="?ap=tema&tema=<?= SCRIPTS->normalizar($_GET['tema']) ?>&accion=Utilizar" class="boton"><?= Language('use') ?></a>
			<a href="?ap=tema&tema=<?= SCRIPTS->normalizar($_GET['tema']) ?>&accion=Normalizar" class="boton"><?= Language('normalize') ?></a>
			<a href="?ap=tema&tema=<?= SCRIPTS->normalizar($_GET['tema']) ?>&accion=Eliminar" class="boton2"><?= Language('delete') ?></a>
		</section>
		<?php endif; ?>
	<?php endif; if (isset($_GET['accion'])) { global $archivo_tema_confirmar; } ?>
	<?= isset($_GET['accion']) && in_array($_GET['accion'], ['eliminar', 'normalizar', 'utilizar']) ?
		'<section class="form" style="text-align: center; margin-top: 0; margin-bottom: 0; color: white; background-color: '. ($archivo_tema_confirmar ? 'green' : 'red') .';"><p>' . (
			$archivo_tema_confirmar ? (
				$_GET['accion'] == 'eliminar' ? Language('file-delete', 'global', ['value' => '']) :
					($_GET['accion'] == 'normalizar' ? Language(['tema', 'default-theme'], 'dashboard') : Language(['tema', 'theme-activated'], 'dashboard'))
			) : ($_GET['accion'] == 'eliminar' ? Language('file-no-deleted') :
					($_GET['accion'] == 'normalizar' ? Language(['tema', 'default-theme-off'], 'dashboard') : Language(['tema', 'theme-no-activated'], 'dashboard'))
		)) . '</p></section>' : '' ?>
<?php } ?>