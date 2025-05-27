<?php $Web['ruta_completa'] = $Web['directorio'].$Web['ruta'];
$Web["config"] = DATA->Config()["config"] ?? [];
$Web["ads"] = DATA->Config()["ads"] ?? [];
$Web["scripts"] = DATA->Config()["scripts"] ?? [];
$Web["template"] = DATA->Read("template/template") ?? [];

if(
	file_exists(RAIZ . 'database/template/scr-template.json') &&
	isset($Web['template']['cargar_scripts']) && !empty($Web['template']['cargar_scripts'])
	){
	if(isset($Web['template']['cargar_scripts_errores']) &&
		empty($Web['template']['cargar_scripts_errores']) or
		!isset($Web['template']['cargar_scripts_errores'])){
		$Web['template']['scr'] = DATA->Read('template/scr-template');
	}
}