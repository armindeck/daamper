<?php # Panel
Ruta(null, "../panel/index.php", function () use ($Web) {
	if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){
		mensajeSpan(['bg'=>'red',
      'text'=> Language('login-required', 'alert'),
      'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
  	]);
	}
  header("Location: {$Web['directorio']}panel/panel.php");
});

Ruta(null, "../panel/panel.php", function () use ($Web) {
	if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){
		mensajeSpan(['bg'=>'red',
      'text'=> Language('login-required', 'alert'),
      'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
    ]);
	}

  if (strtolower($_SESSION['rol']) == 'usuario'){
  	mensajeSpan(['bg'=>'yellow','co'=>'#000',
			'text'=> Language('higher-role-required', 'alert'),
			'ruta'=>"{$Web['directorio']}"
		]);
  }
});

if($Web['ruta_completa'] == '../panel/panel.php' && isset($_GET['ap'])){
	if(in_array($_GET['ap'], ['creador', 'directorio', 'editor', 'tema', 'plantilla'])){
		if(file_exists($Web['directorio'].'panel/app/'.SCRIPTS->normalizar($_GET['ap']).'/url.php')){
			require_once $Web['directorio'].'panel/app/'.SCRIPTS->normalizar($_GET['ap']).'/url.php';
		}
	}
}
?>