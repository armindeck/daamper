<?php
if(isset($_SESSION['id']) || isset($_SESSION['rol'])){
	if(!file_exists($Web['directorio'].AppDatabase('usuarios/usuarios'))){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		mensajeSpan(['bg'=>'red',
            'text'=>'No existe ningún usuario hasta el momento.',
            'ruta'=>"{$Web['directorio']}auth/registrar{$Web['config']['php']}"
        ]);
	}
	require $Web['directorio'].AppDatabase('usuarios/usuarios');
	if(!isset($usu[$_SESSION['id']]) or !isset($usu[$_SESSION['id']]['rol'])){
		unset($_SESSION['id']); unset($_SESSION['rol']);
		mensajeSpan(['bg'=>'red',
            'text'=>'El usuario no existe!',
            'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
        ]);
	}

	if(file_exists($Web['directorio'].AppDatabase('usuarios/usuarios_extras'))){
		require $Web['directorio'].AppDatabase('usuarios/usuarios_extras');
		if($usu[$_SESSION['id']]['estado'] != 'publico'){
			unset($_SESSION['id']); unset($_SESSION['rol']);
			mensajeSpan(['bg'=>'red',
                'text'=>'Este usuario fue suspendido o eliminado.',
                'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
            ]);
		}
	}
	if($_SESSION['rol'] != $usu[$_SESSION['id']]['rol']){
		unset($_SESSION['id']); unset($_SESSION['rol']);
        mensajeSpan(['bg'=>'red',
            'text'=>'El ROL es diferente de los datos almacenados.',
            'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
        ]);
	}
}
?>