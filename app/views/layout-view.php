<!-- daamper core v<?= Daamper::$projectInfo->version ?> (<?= Daamper::$projectInfo->estado ?>) (Copyright © 2024 Armin Deck – Licencia de Uso No Transferible) – https://github.com/armindeck/daamper -->
<!DOCTYPE html>
<html lang="<?= Daamper::$config['language'] ?? "es" ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php // Ruta
	$ruta = (!empty($Web['config']['enlace_web']) ? $Web['config']['enlace_web'].'/' : '') . $Web["ruta"]; // Mostrar enlace o no y agregar la ruta
	$ruta = $AX['archivo'] == "index.php" ? str_replace('index.php', '', $ruta) : $ruta; // Quitar index.php o no
	$ruta = empty($Web['config']['php']) ? str_replace('.php', '', $ruta) : $ruta; // Quitar .php o no
	?><title><?= $AX['titulo'] ?? '' ?> ~ <?= $Web['config']['nombre_web'] ?? Daamper::$projectInfo->nombre ?></title>
	<link rel="preload" href="<?= ($Web['config']['https_imagen'] ?? "") . Daamper::imgPath('logo.png') ?>" as="image">
	<link rel="icon" type="image/png" href="<?= ($Web['config']['https_imagen'] ?? "") . Daamper::imgPath('logo.png') ?>" sizes="128x128">
	<meta name="description" content="<?= $AX['descripcion'] ?? '' ?>" />
	<meta property="og:title" content="<?= $AX['titulo'] ?? '' ?>" />
	<meta property="og:description" content="<?= $AX['descripcion'] ?? '' ?>" />
	<meta property="og:url" content="<?= $ruta ?>">
	<link rel="canonical" href="<?= $ruta ?>">
	<meta property="og:image" content="<?= ImagenesACX($AX, false, ['miniatura', 'miniatura_url']) ?>" />
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?= $Web['config']['nombre_web'] ?? Daamper::$projectInfo->nombre ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?= $AX['titulo'] ?? '' ?>">
	<meta name="twitter:description" content="<?= $AX['descripcion'] ?? '' ?>">
	<meta name="twitter:image" content="<?= ImagenesACX($AX, false, ['miniatura', 'miniatura_url']) ?>">
	<meta name="keywords" content="<?= ($AX['meta_etiquetas'] ?? '') . ', '.($Web['config']['nombre_web'] ?? '').', '.($Web['config']['enlace_web_simple'] ?? '').', '.($Web['config']['enlace_web'] ?? '') ?>">
	<link rel="stylesheet" href="<?= "{$Web['directorio']}assets/css/{$Web["config"]["theme"]}" ?>">
	<?php foreach (['google_scripts','font_awesome_scripts','other_scripts'] as $key => $value){
		if(!empty($Web['scripts']['show_'.$value])){ echo ($Web['scripts'][$value] ?? "") . "\n"; }
	} ?>
	<?php if(file_exists($Web['directorio'].'app/actions/admin/content/src/theme.php')){
        require_once $Web['directorio'] . 'app/actions/admin/content/src/theme.php';
   } ?>
</head>
<body data-theme="<?= $_SESSION['tmp']['color'] ?? $Web["config"]["color"] ?? "light" ?>">
	<?php // Vistas
	Daamper::views('privado-error'); // Pagina de error
	ViewsPlantilla(null, true); // Cargar todas las vistas necesarias
	
	# CARGAR INDIVIDUALMENTE ----------
	/*
	<?= ViewsPlantilla("components", true) ?>
	<?= ViewsPlantilla("header", true) ?>
	<?= ViewsPlantilla("header-bar", true) ?>
	<?= ViewsPlantilla("sidebar", true) ?>
	<?= ViewsPlantilla("open-content", true) ?>
		<?= ViewsPlantilla("main-header", true) ?>
			<?= ViewsPlantilla("main", true) ?>
		<?= ViewsPlantilla("main-footer", true) ?>
		<?= ViewsPlantilla("article", true) ?>
	<?= ViewsPlantilla("close-content", true) ?>
	<?= ViewsPlantilla("footer", true) ?>
	*/
	?>
	<?php unset($_SESSION["sendAlert"]); ?>
</body>
</html>