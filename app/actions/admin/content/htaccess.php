<?php
$LISTA_DATOS_POST=[
	'error_400','error_401','error_403','error_404','error_500','error_503','todo_https','errores'
];

$post=[];
foreach ($LISTA_DATOS_POST as $key => $value) {
	$post[$value]=Daamper::$scripts->normalizar2($_POST[$value] ?? "");
}

$guardar = '';

$text_replace = [
  "debug" => "# REPLACE_SHOW_ERROR",
  "ssl" => "# REPLACE_REDIRECT_HTTPS",
  "links" => "# REPLACE_ERROR_LINK"
];

$code_show_error = "php_flag display_errors On\nphp_flag display_startup_errors On\nphp_value error_reporting -1";
$code_redirect_https = "RewriteCond %{HTTPS} off\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]";
$code_change_error_link =
  "ErrorDocument 400 {$post['error_400']}\n".
  "ErrorDocument 401 {$post['error_401']}\n".
  "ErrorDocument 403 {$post['error_403']}\n".
  "ErrorDocument 404 {$post['error_404']}\n".
  "ErrorDocument 500 {$post['error_500']}\n".
  "ErrorDocument 503 {$post['error_503']}";

$read_htaccess = file_exists($Web['directorio'].'/database/files/txt/htaccess.txt') ?
	file_get_contents($Web['directorio'].'/database/files/txt/htaccess.txt') : '';

$modify = $read_htaccess;
$modify = !empty($_POST['errores']) ?
	str_replace($text_replace["debug"], $code_show_error, $modify) : $modify;

$modify = !empty($_POST['todo_https']) ? str_replace($text_replace["ssl"], $code_redirect_https, $modify) : $modify;
$modify = str_replace($text_replace["links"], $code_change_error_link, $modify);

file_put_contents($Web['directorio'].'.htaccess', $modify);

$DATOS_DEFAULT = true;