<?php $Web['ruta_completa'] = $Web['directorio'].$Web['ruta'];
$Web["config"] = Daamper::$data->Config()["config"] ?? [];
$Web["ads"] = Daamper::$data->Config()["ads"] ?? [];
$Web["scripts"] = Daamper::$data->Config()["scripts"] ?? [];
$Web["template"] = Daamper::$data->Read("template/template") ?? [];

if(
	file_exists(RAIZ . 'database/template/scr-template.json') &&
	isset($Web['template']['cargar_scripts']) && !empty($Web['template']['cargar_scripts'])
	){
	if(isset($Web['template']['cargar_scripts_errores']) &&
		empty($Web['template']['cargar_scripts_errores']) or
		!isset($Web['template']['cargar_scripts_errores'])){
		$Web['template']['scr'] = Daamper::$data->Read('template/scr-template');
	}
}