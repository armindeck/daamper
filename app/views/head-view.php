	<?php $ruta = isset($Web['config']['enlace_web']) && !empty($Web['config']['enlace_web']) ? $Web['config']['enlace_web'].'/' : '';
	if($AX['archivo'] == 'index.php'){ $ruta .= str_replace('index.php', '', $Web['ruta']); } else {
		$ruta .= isset($Web['config']['php']) && empty($Web['config']['php']) ? str_replace('.php', '', $Web['ruta']) : $Web['ruta'];
	} ?>
	<title><?= $AX['titulo'] ?? '' ?> ~ <?= $Web['config']['nombre_web'] ?? WEBSITE->nombre ?></title>
	<link rel="preload" href="<?= $Web['config']['https_imagen'] . AssetsImg('logo.png') ?>" as="image">
	<link rel="icon" type="image/png" href="<?= $Web['config']['https_imagen'] . AssetsImg('logo.png') ?>" sizes="128x128">
	<meta name="description" content="<?= $AX['descripcion'] ?? '' ?>" />
	<meta property="og:title" content="<?= $AX['titulo'] ?? '' ?>" />
	<meta property="og:description" content="<?= $AX['descripcion'] ?? '' ?>" />
	<meta property="og:url" content="<?= $ruta ?>">
	<link rel="canonical" href="<?= $ruta ?>">
	<meta property="og:image" content="<?= ImagenesACX($AX, false, ['miniatura', 'miniatura_url']) ?>" />
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?= $Web['config']['nombre_web'] ?? '' ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?= $AX['titulo'] ?? '' ?>">
	<meta name="twitter:description" content="<?= $AX['descripcion'] ?? '' ?>">
	<meta name="twitter:image" content="<?= ImagenesACX($AX, false, ['miniatura', 'miniatura_url']) ?>">
	<meta name="keywords" content="<?= ($AX['meta_etiquetas'] ?? '') . ', '.($Web['config']['nombre_web'] ?? '').', '.($Web['config']['enlace_web_simple'] ?? '').', '.($Web['config']['enlace_web'] ?? '') ?>">
	<!--
		Theme Name: <?= WEBSITE->nombre ?>' Theme
		Theme URL: <?= WEBSITE->enlace . "\n" ?>
		Author: <?= WEBSITE->creador . "\n" ?>
		Author URL: <?= WEBSITE->creador_enlace . "\n" ?>
		Versión: <?= WEBSITE->version .' '.WEBSITE->estado.' '.WEBSITE->mod . "\n" ?>
	-->
	<?php require_once $Web['directorio'] . 'assets/css/styles.php'; ?>
	<?php foreach (['scripts_google','scripts_font_awesome','scripts_otros'] as $key => $value){
		if(isset($Web['scripts']['mostrar_'.$value]) && !empty($Web['scripts']['mostrar_'.$value])){
			if(file_exists($Web["directorio"].'database/files/html/'.$value.'.html')){
				require $Web["directorio"].'database/files/html/'.$value.'.html';
				echo "\n";
			}
		}
	} ?>
	<?= file_exists(($Web['directorio'] != './' ? $Web['directorio'] : '').'../elementos/js/all.js') ? '<script src="'.(($Web['directorio'] != './' ? $Web['directorio'] : '').'../elementos/js/all.js').'"></script>' : '' ?>
	<?php if(file_exists($Web['directorio'].'app/actions/admin/content/src/theme.php')){
        require_once $Web['directorio'] . 'app/actions/admin/content/src/theme.php';
   } ?>
