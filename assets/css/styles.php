<style type="text/css">
<?php global $AX; ?>
<?php foreach ([
	(isset($_SESSION['tmp']['tema']) ? 'theme/'.$_SESSION['tmp']['tema'] : 'theme/blue-aero'),
	'global',
	'styles',
	'components/header',
	'components/header-bar',
	'components/sidebar',
	'components/overlay',
	'components/content',
	'components/article',
	'components/footer',
	substr($Web['ruta'], 0, 2) == 'p/' ? 'components/main-perfil' : '',
	'components/main-panel',
	'components/acciones',
	'components/form-comentarios',
	$Web['ruta'] == 'error.php' ? 'components/privado-error' : '',
	'components/media',
	$AX['archivo'] == 'index.php' ? 'components/entradas-normal' : '',
	in_array($AX['ruta'], ['anime/', 'juego/']) && $AX['archivo'] != 'index.php' ? 'components/main-anime-entrada' : '',
	in_array($AX['ruta'], ['juego/']) && $AX['archivo'] != 'index.php' ? 'components/gallery' : '',
	$AX['ruta'] == 'ver/' && $AX['archivo'] != 'index.php' ? 'components/main-anime-mirando' : '',
	] as $key => $value) {
		if (!empty($value)) {
			if (file_exists(__DIR__ . "/$value.css")){
				include __DIR__ . "/$value.css"; echo "\n\n";
			} else {
				echo "/* El archivo $value.css no existe. */\n\n";
			}
		}
} ?>
</style>