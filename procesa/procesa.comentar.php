<?php # 07/11/2024 ~ 12:04am | 02/01/2025
$Web['directorio'] = '../'; $Web['ruta'] = 'procesa/procesa.comentar.php';

require_once $Web['directorio'].'app/control/control_procesa.php';

$TIPO = isset($_POST['comentar']) && !empty($_POST['comentar']) ? 'comentar' : (isset($_POST['responder']) && !empty($_POST['responder']) ? 'responder' : '');

$get['ruta'] = !isset($_GET['ruta']) || empty($_GET['ruta']);

if (empty($TIPO) || $get['ruta']) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("incorrect-data", "alert"));
}

# RUTA
if (md5('R+_'. $_GET['ruta'] . '-W') !== $_POST['token']) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("do-not-modify-hidden-fields", "alert"));
}

$get['ruta'] = SCRIPTS->normalizar2($_GET['ruta']);
$get['ruta_php'] = $Web['directorio'] . str_replace('.php', '', $get['ruta']) . $Web['config']['php'];
$get['ruta_completa'] = $Web['directorio'] . $get['ruta'];

if (!file_exists($get['ruta_completa'])) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("do-not-modify-hidden-fields", "alert"));
}

# SUMA
if (md5('R+_'. $_POST['resultado'] . '-W') !== $_POST['resultado_verificar']) {
    mensajeSpan(['bg'=>'yellow', 'co'=>'#000',
        'text'=> Language("incorrect-sum", "alert"),
        'ruta'=>"{$get['ruta_php']}"
    ]);
}

if (!file_exists('../app/database/comentarios/')){
    if(!mkdir('../app/database/comentarios/', 0777, true));
}

$db = $Web['directorio'] . AppDatabase('comentarios/comentarios');
if (!file_exists($db)) { file_put_contents($db, "<?php return [\n];"); }

$comentarios = require_once $db;
$comentarios_ids = count($comentarios) + 1;


$post['id'] = $comentarios_ids;
$post['id_usuario'] = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$post['id_comentario'] = '';
if ($TIPO == 'responder') {
    if (isset($_POST['token-responder']) && !empty($_POST['token-responder'])) {
        for ($i = 1; $i <= count($comentarios); $i++) {
            if (md5('R+_' . $i . '-W') == SCRIPTS->normalizar2($_POST['token-responder'])) { $post['id_comentario'] = $i; $encontro = true; break; }
        }
        if (!isset($encontro)) {
            mensajeSpan(['bg'=>'yellow', 'co'=>'#000',
                'text'=> Language("do-not-modify-hidden-fields", "alert"),
                'ruta'=>"{$get['ruta_php']}"
            ]);
        }
    }
}
$post['ruta'] = $get['ruta'];
$post['apodo'] = !isset($_SESSION['id']) ? SCRIPTS->normalizar($_POST['apodo']) : '';
$post['comentario'] = isset($_POST['comentario']) && !empty($_POST['comentario']) ? SCRIPTS->normalizar($_POST['comentario']) : '';
foreach (['enlace', 'enlace_imagen'] as $key => $value) {
    $post[$value] = isset($_POST[$value]) && !empty($_POST[$value]) && filter_var($_POST[$value], FILTER_VALIDATE_URL) ? SCRIPTS->normalizar($_POST[$value]) : '';
}
$post['estado'] = 'publico';
$post['fecha'] = SCRIPTS->fecha_hora();


$file = file_get_contents($db);
$file_mod = str_replace('];', '', $file);
$file_mod .= $comentarios_ids . ' => [';


foreach ($post as $key => $value) {
    $file_mod .= "'$key' => '$value', ";
}

$file_mod .= "],\n];";

if (isset($_GET['sub-ruta']) && $_GET['sub-ruta'] == 'panel-comentarios') {
    $get['ruta_php'] = $Web['directorio'] . 'panel/panel.php?ap=comentarios';
}

if (file_put_contents($db, $file_mod)) {
    mensajeSpan(['bg'=>'green',
            'text'=> Language("thanks-for-commenting", "alert"),
            'ruta'=>"{$get['ruta_php']}"
        ]);
} else {
    mensajeSpan(['bg'=>'red',
        'text'=> Language("data-not-saved", "alert"),
        'ruta'=>"{$get['ruta_php']}"
    ]);
}