<?php # Auth
if ($Web['ruta_completa'] == '../auth/configuracion.php' && !isset($_SESSION['id'])){
	mensajeSpan(['bg'=>'red',
		'text'=> Language('please-login', 'alert'),
		'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
	]);
}

Ruta(null,
  isset($_SESSION['cambiar_contrasena']) &&
  $Web['ruta_completa'] != '../auth/cambiar-contrasena.php',
  function () use ($Web) {
    mensajeSpan(['bg'=>'red',
      'text'=> Language('change-password', 'alert'),
      'ruta'=>"{$Web['directorio']}auth/cambiar-contrasena{$Web['config']['php']}"
    ]);
});

Ruta(null,
  !isset($_SESSION['id']) && $Web['ruta_completa'] == '../auth/cambiar-contrasena.php',
  function () use ($Web) {
    mensajeSpan(['bg'=>'yellow','co'=>'#000',
      'text'=> Language('no-access', 'alert'),
      'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
    ]);
});

Ruta(null,
  in_array($Web['ruta_completa'], ['../auth/iniciar.php', '../auth/registrar.php', '../auth/olvide-contrasena.php']),
  function () use ($Web) {
    if(isset($_SESSION['id']) && isset($_SESSION['rol'])){
      require $Web['directorio'].AppDatabase('usuarios/usuarios');
      header("Location: {$Web['directorio']}p/{$usu[$_SESSION['id']]['usuario']}{$Web['config']['php']}");
    }
}); ?>