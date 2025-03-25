<?php
if(isset($_SESSION['id']) || isset($_SESSION['rol'])){
	if(!file_exists($Web['directorio'].AppDatabase('usuarios/usuarios'))){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		mensajeSpan(['bg'=>'red',
            'text'=> Language('user-not-found', 'alert'),
            'ruta'=>"{$Web['directorio']}auth/registrar{$Web['config']['php']}"
        ]);
	}
	require $Web['directorio'].AppDatabase('usuarios/usuarios');
	if(!isset($usu[$_SESSION['id']]) or !isset($usu[$_SESSION['id']]['rol'])){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		mensajeSpan(['bg'=>'red',
            'text'=> Language('user-not-exist', 'alert'),
            'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
        ]);
	}

	if(file_exists($Web['directorio'].AppDatabase('usuarios/usuarios_extras'))){
		require $Web['directorio'].AppDatabase('usuarios/usuarios_extras');
		if($usu[$_SESSION['id']]['estado'] != 'publico'){
			unset($_SESSION['id']); unset($_SESSION['rol']);
			mensajeSpan(['bg'=>'red',
                'text'=> Language('user-suspended-deleted', 'alert'),
                'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
            ]);
		}
	}
	if($_SESSION['rol'] != $usu[$_SESSION['id']]['rol']){
		unset($_SESSION['id']); unset($_SESSION['rol']);
        mensajeSpan(['bg'=>'red',
            'text'=> Language('role-mismatch', 'alert'),
            'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
        ]);
	}
}
?>