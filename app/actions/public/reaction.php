<?php # 07/11/2024 ~ 12:04am | 30/03/2025 ~ 6:53pm | 23/05/2025 ~ 5:40pm
$Web['directorio'] = '../'; $Web['ruta'] = 'process/reaction.php';
require_once $Web['directorio'].'app/controller/admin.php';

if (!isset($_POST['me_gusta']) && !isset($_POST['no_me_gusta']) || !isset($_SESSION['id'])) {
    sendAlert->Warning(Language("login-or-do-not-modify-hidden-fields", "alert"), $Web['directorio']);
}

if (isset($_POST['me_gusta'])) { $TIPO = 'me_gusta'; } elseif (isset($_POST['no_me_gusta'])) { $TIPO = 'no_me_gusta'; }

$lista = ['token-comentario'];
foreach ($lista as $key => $value) {
    if (!isset($_POST[$value]) || empty($_POST[$value])) {
        sendAlert->Error(Language("fill-all-fields", "alert"), $Web['directorio']);
    }
    $post[$value] = SCRIPTS->normalizar2($_POST[$value]);
}

$file_comentarios = DATA->CommentRoute();
$comentarios = [];
if (file_exists($file_comentarios)){ $comentarios = DATA->CommentAll(); }
if (count($comentarios) <= 0) {
    sendAlert->Error(Language("no-comments-yet", "alert"), $Web['directorio']);
}
for ($i = 1; $i <= count($comentarios); $i++) {
    if (SCRIPTS->SimpleToken($i) == $post['token-comentario']) { $id = $i; $encontro = true; break; }
}
if (!isset($encontro)) {
    sendAlert->Error(Language("comment-to-react-not-exist", "alert"), $Web['directorio']);
}

if ($comentarios[$id]['estado'] != 'publico') {
    header("Location: {$Web['directorio']}");
}

$ruta = $Web['directorio'] . str_replace(".php", "", $comentarios[$id]['ruta']) . $Web['config']['php'];

$post['me_gusta'] = '';
$post['no_me_gusta'] = '';

if ($TIPO == 'me_gusta') {
    $post['me_gusta'] = 1;
} else {
    $post['no_me_gusta'] = 1;
}

$post['fecha'] = SCRIPTS->fecha_hora();

if (!file_exists(DATA->CommentRoute(true))) { DATA->Save(DATA->CommentRoute(true, false), []); }
$file_comentarios_extras_leer = DATA->Comment("extras");

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
            break;
        }
        $conteo++;
    }
}
$file_comentarios_extras_leer[$id]['reacciones'][$reacciones] = ['id_usuario' => $_SESSION['id'], 'me_gusta' => $post['me_gusta'], 'no_me_gusta' => $post['no_me_gusta'], 'fecha' => $post['fecha']];
$resultado = DATA->UpdateComment($file_comentarios_extras_leer, true);
$usu = DATA->UserAll();

$nombre = '<strong>' . (!empty($comentarios[$id]['apodo']) ? $comentarios[$id]['apodo'] : $usu[($comentarios[$id]['id_usuario'])]['nombre']) . '</strong>';

if (isset($_GET['sub-ruta']) && $_GET['sub-ruta'] == 'admin-comments') {
    $ruta = $Web['directorio'] . 'admin/admin'.$Web['config']['php'].'?ap=comments';
}

if (!$resultado) {
    sendAlert->Error(Language("failed-to-react-comment", "alert", ['value' => $nombre]), $ruta);
}

sendAlert->Success(Language("reacted-to-comment", "alert", ['value' => $nombre]), $ruta);