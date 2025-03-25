<?php

$LISTA_DATOS_POST=[
	'error_400','error_401','error_403','error_404','error_500','error_503','todo_https','errores','timezone'
];

$post=[];
foreach ($LISTA_DATOS_POST as $key => $value) {
	if(!isset($_POST[$value])){ $_POST[$value]=''; }
	$post[$value]=SCRIPTS->normalizar2($_POST[$value]);
}

$guardar = '';
	
if(!empty($post['errores'])){
	$guardar .= "php_value display_errors On\n";
}
if(!empty($post['timezone'])){
	$guardar .= "php_value date.timezone {$Web['config']['timezone']}\n";
}

if(!empty($post['todo_https'])){
	$guardar .= "RewriteEngine On\nRewriteCond %{SERVER_PORT} 80\n";
	$guardar .= "RewriteRule ^(.*)$ {$Web['config']['enlace_web']}/$1 [R,L]\n\n";
}

$guardar .= file_exists(__DIR__.'/htaccess.txt') ?
	file_get_contents(__DIR__.'/htaccess.txt')."\n\n" : '';

foreach ($post as $key => $value) {
	if($key!='todo_https' && $key!='errores' && $key!='timezone'){
		$guardar .= "ErrorDocument ".str_replace('error_', '', $key)." ".$value."\n";
	}
}

file_put_contents($Web['directorio'].'.htaccess', $guardar);
file_put_contents($Web['directorio'].'panel/.htaccess', $guardar);

$DATOS_DEFAULT = true;
?>