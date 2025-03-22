<?php
function mensajeSpan($list){
	if(!isset($list['co'])){ $list['co']='#FFF'; }
	if(!isset($list['bg'])){ $list['bg']='green'; }
	if(!isset($list['text'])){ $list['text']='Default'; }
	
	$_SESSION['mensaje_span'] = $list;
	if(isset($list['tmpForm'])){ $_SESSION['tmpForm']=$list['tmpForm']; }
	if(isset($list['ruta'])){
		header("Location: {$list['ruta']}");
		exit;
	}
}


?>