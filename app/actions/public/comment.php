<?php # 07/11/2024 ~ 12:04am | 02/01/2025 | 23/05/2025
$Web['directorio'] = '../'; $Web['ruta'] = 'process/comment.php';
require_once $Web['directorio'].'app/controller/admin.php';

$TIPO = isset($_POST['comentar']) && !empty($_POST['comentar']) ? 'comentar' : (isset($_POST['responder']) && !empty($_POST['responder']) ? 'responder' : '');

$get['ruta'] = !isset($_GET['ruta']) || empty($_GET['ruta']);

if (empty($TIPO) || $get['ruta']) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("incorrect-data", "alert"));
}

# RUTA
if (SCRIPTS->SimpleToken($_GET['ruta']) !== $_POST['token']) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("do-not-modify-hidden-fields", "alert"));
}

$get['ruta'] = SCRIPTS->normalizar2($_GET['ruta']);
$get['ruta_php'] = $Web['directorio'] . str_replace('.php', '', $get['ruta']) . $Web['config']['php'];
if (isset($_GET['sub-ruta']) && $_GET['sub-ruta'] == 'admin-comments') {
    $get['ruta_php'] = $Web['directorio'] . 'admin/admin'.$Web['config']['php'].'?ap=comments';
}
$get['ruta_completa'] = $Web['directorio'] . $get['ruta'];

if (!file_exists($get['ruta_completa'])) {
    header("Location: {$Web['directorio']}error{$Web['config']['php']}?e=".Language("do-not-modify-hidden-fields", "alert"));
}

# SUMA
if (SCRIPTS->SimpleToken($_POST['resultado']) !== $_POST['resultado_verificar']) {
    sendAlert->Warning(Language("incorrect-sum", "alert"), $get['ruta_php']);
}

if(!isset($_POST['new-token'])){
    sendAlert->Warning(Language("do-not-modify-hidden-fields", "alert"), $get['ruta_php']);
}

SCRIPTS->CrearCarpetas("database/comment/");

$db = DATA->CommentRoute();
if (!file_exists($db)) { DATA->Save(DATA->CommentRoute(false, false), []); }

$comentarios = DATA->Comment() ?? [];
$comentarios_ids = count($comentarios) + 1;
$cantidad_comentario = count($comentarios);

$post['id'] = $comentarios_ids;
$post['id_usuario'] = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$post['id_comentario'] = '';
if ($TIPO == 'responder') {
    if (isset($_POST['token-responder']) && !empty($_POST['token-responder'])) {
        for ($i = 1; $i <= count($comentarios); $i++) {
            if (SCRIPTS->SimpleToken($i) == SCRIPTS->normalizar2($_POST['token-responder'])) { $post['id_comentario'] = $i; $encontro = true; break; }
        }
        if (!isset($encontro)) {
            sendAlert->Warning(Language("do-not-modify-hidden-fields", "alert"), $get['ruta_php']);
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

if(isset($_SESSION["id"])){
    $token = $_SESSION["id"];
} else {
    $token = SCRIPTS->normalizar($_POST['new-token']);
}

$post['hash'] = SCRIPTS->hash($post["ruta"], $post["comentario"] . "|" . $token);

foreach ($comentarios as $key => $value) {
    if(isset($value["hash"]) && $value["hash"] == $post["hash"]){
        sendAlert->Error(Language("comment-already-sent", "alert"), $get['ruta_php']);
        break;
    }
}

$comentarios[$comentarios_ids] = $post;
$confirmar = DATA->Save(DATA->CommentRoute(false, false), $comentarios);

if (!$confirmar) {
    sendAlert->Error(Language("data-not-saved", "alert"), $get['ruta_php']);
}

sendAlert->Success(Language("thanks-for-commenting", "alert"), $get['ruta_php']);