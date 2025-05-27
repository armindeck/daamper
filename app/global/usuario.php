<?php
if(isset($_SESSION['id']) || isset($_SESSION['rol'])){
	if(!file_exists(DATA->UserRoute())){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		sendAlert->Error(Language('user-not-found', 'alert'),
        	"{$Web['directorio']}auth/register{$Web['config']['php']}"
        );
	}
	$usu = DATA->User();
	if(!isset($usu[$_SESSION['id']]) or !isset($usu[$_SESSION['id']]['rol'])){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		sendAlert->Error(Language('user-not-exist', 'alert'),
        	"{$Web['directorio']}auth/login{$Web['config']['php']}"
        );
	}

	if(file_exists(DATA->UserRoute(true))){
		$usu = DATA->UserAll();
		if($usu[$_SESSION['id']]['estado'] != 'publico'){
			unset($_SESSION['id']); unset($_SESSION['rol']);
			sendAlert->Error(Language('user-suspended-deleted', 'alert'),
            	"{$Web['directorio']}auth/login{$Web['config']['php']}"
            );
		}
	}
	if($_SESSION['rol'] != $usu[$_SESSION['id']]['rol']){
		unset($_SESSION['id']); unset($_SESSION['rol']);
        sendAlert->Error(Language('role-mismatch', 'alert'),
        	"{$Web['directorio']}auth/login{$Web['config']['php']}"
        );
	}
}