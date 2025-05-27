<style type="text/css">
<?php global $AX; ?>
<?php foreach ([
	(isset($_SESSION['tmp']['tema']) ? 'template/daamper/theme/'.$_SESSION['tmp']['tema'] : 'template/daamper/theme/blue-aero'),
	'global',
	'styles',
	'template/daamper/components/header',
	'template/daamper/components/header-bar',
	'template/daamper/components/sidebar',
	'template/daamper/components/overlay',
	'template/daamper/components/content',
	'template/daamper/components/article',
	'template/daamper/components/footer',
	substr($Web['ruta'], 0, 2) == 'p/' ? 'template/daamper/components/main-perfil' : '',
	'template/daamper/components/main-panel',
	'template/daamper/components/acciones',
	'template/daamper/components/form-comentarios',
	'template/daamper/components/alert-pin',
	$Web['ruta'] == 'error.php' ? 'template/daamper/components/privado-error' : '',
	'template/daamper/components/media',
	$AX['archivo'] == 'index.php' ? 'template/daamper/components/entradas-normal' : '',
	in_array($AX['ruta'], ['anime/', 'juego/']) && $AX['archivo'] != 'index.php' ? 'template/daamper/components/main-anime-entrada' : '',
	in_array($AX['ruta'], ['juego/']) && $AX['archivo'] != 'index.php' ? 'template/daamper/components/gallery' : '',
	$AX['ruta'] == 'ver/' && $AX['archivo'] != 'index.php' ? 'template/daamper/components/main-anime-mirando' : '',
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