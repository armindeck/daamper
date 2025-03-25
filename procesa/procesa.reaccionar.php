<?php # 07/11/2024 ~ 12:04am
$Web['directorio'] = '../'; $Web['ruta'] = 'procesa/procesa.reaccionar.php';
require_once $Web['directorio'].'app/control/control_procesa.php';

if (!isset($_POST['me_gusta']) && !isset($_POST['no_me_gusta']) || !isset($_SESSION['id'])) {
    mensajeSpan(['bg'=>'yellow', 'co' => 'black',
        'text'=>'Por favor inicie sesión o no modifique los campos ocultos.',
        'ruta'=>$Web['directorio']
    ]);
}

if (isset($_POST['me_gusta'])) { $TIPO = 'me_gusta'; } elseif (isset($_POST['no_me_gusta'])) { $TIPO = 'no_me_gusta'; }

$lista = ['token-comentario'];
foreach ($lista as $key => $value) {
    if (!isset($_POST[$value]) || empty($_POST[$value])) {
        mensajeSpan(['bg'=>'red',
            'text'=>'Por favor llene todos los campos.',
            'ruta'=> $Web['directorio']
        ]);
    }
    $post[$value] = SCRIPTS->normalizar2($_POST[$value]);
}

$file_comentarios = $Web['directorio'] . AppDatabase('comentarios/comentarios');
$comentarios = 0;
if (file_exists($file_comentarios)){ $comentarios = require_once $file_comentarios; }
if (count($comentarios) <= 0) {
    mensajeSpan(['bg'=>'red',
            'text'=>'Todavia no hay comentarios',
            'ruta'=>$Web['directorio']
        ]);
}
for ($i = 1; $i <= count($comentarios); $i++) {
    if (md5('R+_' . $i . '-W') == $post['token-comentario']) { $id = $i; $encontro = true; break; }
}
if (!isset($encontro)) {
    mensajeSpan(['bg'=>'red',
        'text'=>'¡Oh! ~ Parece que el comentario que va a reaccionar no existe!',
        'ruta'=>$Web['directorio']
    ]);
}

if ($comentarios[$id]['estado'] != 'publico') {
    header("Location: {$Web['directorio']}");
}

$ruta = $Web['directorio'] . $comentarios[$id]['ruta'];

$post['me_gusta'] = '';
$post['no_me_gusta'] = '';

if ($TIPO == 'me_gusta') {
    $post['me_gusta'] = 1;
} else {
    $post['no_me_gusta'] = 1;
}

$post['fecha'] = SCRIPTS->fecha_hora();

$file_comentarios_extras = $Web['directorio'] . AppDatabase('comentarios/comentarios_extras');
if (!file_exists($file_comentarios_extras)) { file_put_contents($file_comentarios_extras, "<?php\n"); }
$file_comentarios_extras_leer = file_get_contents($file_comentarios_extras);

require $file_comentarios_extras;
$reacciones = 1;
$conteo = 1;
if (isset($comentarios[$id]['reacciones'])) { $reacciones = count($comentarios[$id]['reacciones']) + 1;
    foreach ($comentarios[$id]['reacciones'] as $key => $value) {
        if ($value['id_usuario'] == $_SESSION['id']) { $reacciones = $conteo;
            if ($TIPO == 'me_gusta') {
                $post['no_me_gusta'] = '';
                if (!empty($comentarios[$id]['reacciones'][$conteo]['me_gusta'])) { $post['me_gusta'] = ''; } else { $post['me_gusta'] = 1; }
            } else {
                $post['me_gusta'] = '';
                if (!empty($comentarios[$id]['reacciones'][$conteo]['no_me_gusta'])) { $post['no_me_gusta'] = ''; } else { $post['no_me_gusta'] = 1; }
            }
            $file_comentarios_extras_leer = EliminarLinea($Web['directorio'] . AppDatabase('comentarios/comentarios_extras'), "\$comentarios[$id]['reacciones'][$reacciones]");
            break;
        }
        $conteo++;
    }
}
$dato = "$" . "comentarios[$id]['reacciones'][$reacciones] = ['id_usuario' => {$_SESSION['id']}, 'me_gusta' => '{$post['me_gusta']}', 'no_me_gusta' => '{$post['no_me_gusta']}', 'fecha' => '{$post['fecha']}'];\n";
$resultado = file_put_contents($file_comentarios_extras, $file_comentarios_extras_leer . $dato);
require $Web['directorio'] . AppDatabase('usuarios/usuarios');

$nombre = '<strong>' . (!empty($comentarios[$id]['apodo']) ? $comentarios[$id]['apodo'] : $usu[($comentarios[$id]['id_usuario'])]['nombre']) . '</strong>.';

if ($resultado) {
    mensajeSpan(['bg'=>'green',
        'text'=>'Reaccionaste al comentario de ' . $nombre,
        'ruta'=>$ruta
    ]);
}
mensajeSpan(['bg'=>'red',
    'text'=>'Fallo al reaccionar al comentario de ' . $nombre,
    'ruta'=>$ruta
]);
?>