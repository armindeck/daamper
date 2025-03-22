<?php foreach (['usuarios/'=>['usuarios','usuarios_extras']] as $key => $value) {
	foreach ($value as $value2) {
		if(file_exists(__DIR__ . "/{$key}{$value2}.php")){ require_once __DIR__ . "/{$key}{$value2}.php"; }
	}
} if(isset($usu)){ define('usu', $usu); } unset($usu); ?>