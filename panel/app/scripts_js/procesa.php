<?php
$LISTA_DATOS_POST = [
	'scripts_js_google','scripts_js_font_awesome','scripts_js_otros',
];
foreach ($LISTA_DATOS_POST as $key => $value) {
	if(isset($_POST[$value]) && !empty($_POST[$value])){
		file_put_contents(__DIR__.'/web-'.$value.'.html', trim($_POST[$value]));
	} else {
		if(file_exists(__DIR__.'/web-'.$value.'.html')){
			unlink(__DIR__.'/web-'.$value.'.html');
		}
	}
}


$LISTA_DATOS_POST = [
	'mostrar_scripts_js_google','mostrar_scripts_js_font_awesome',
	'mostrar_scripts_js_otros',
];


$DATOS_DEFAULT = true;
?>