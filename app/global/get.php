<?php # CERRAR SESIÓN
if(isset($_GET['cerrar-sesion']) && isset($_SESSION['id'])){
	unset($_SESSION['id']); unset($_SESSION['rol']); unset($_SESSION['cambiar_contrasena']);
	mensajeSpan(['bg'=>'green',
		'text'=>'Hasta la proxima!',
		'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
	]);
}
# TEMA
if (isset($_GET['tema']) && !empty($_GET['tema'])) {
    if (file_exists($Web['directorio'] . AssetsCss('theme/'.SCRIPTS->normalizar2($_GET['tema'])))) {
        $_SESSION['tmp']['tema'] = SCRIPTS->normalizar2($_GET['tema']);
    }
} ?>