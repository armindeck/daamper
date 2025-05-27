<?php # Auth
if ($Web['ruta_completa'] == '../auth/config.php' && !isset($_SESSION['id'])){
  sendAlert->Error(Language('please-login', 'alert'),
		"{$Web['directorio']}auth/login{$Web['config']['php']}"
	);
}

Ruta(null,
  isset($_SESSION['cambiar_contrasena']) &&
  $Web['ruta_completa'] != '../auth/change-password.php',
  function () use ($Web) {
    sendAlert->Error(Language('change-password', 'alert'),
      "{$Web['directorio']}auth/change-password{$Web['config']['php']}"
    );
});

Ruta(null,
  !isset($_SESSION['id']) && $Web['ruta_completa'] == '../auth/change-password.php',
  function () use ($Web) {
    sendAlert->Warning(Language('no-access', 'alert'),
      "{$Web['directorio']}auth/login{$Web['config']['php']}"
    );
});

Ruta(null,
  in_array($Web['ruta_completa'], ['../auth/login.php', '../auth/register.php', '../auth/forgot-password.php']),
  function () use ($Web) {
    if(isset($_SESSION['id']) && isset($_SESSION['rol'])){
      $usuario = DATA->User()[$_SESSION["id"]]["usuario"];
      header("Location: {$Web['directorio']}p/{$usuario}{$Web['config']['php']}");
    }
}); ?>