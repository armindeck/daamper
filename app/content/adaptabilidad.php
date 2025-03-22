<?php if(isset($Web['config']['https_imagen']) && empty($Web['config']['https_imagen']) or !isset($Web['config']['https_imagen'])){
	$Web['config']['https_imagen'] = $Web['directorio'];
}
if(isset($Web['config']['timezone']) && !empty($Web['config']['timezone'])){ date_default_timezone_set($Web['config']['timezone']); }
?>