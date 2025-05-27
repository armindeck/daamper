<?php # 23/03/2025
$Web['directorio'] = '../'; $Web['ruta'] = 'process/report.php';
require_once $Web['directorio'].'app/controller/admin.php';

if (!isset($_POST['reportar']) || !isset($_SESSION['id'])) {
    sendAlert->Warning(Language("login-or-do-not-modify-hidden-fields", "alert"), $Web['directorio']);
}

$lista = ['motivos', 'motivos_texto', 'token-comentario', 'resultado', 'resultado_verificar'];
foreach ($lista as $key => $value) {
    if (!isset($_POST[$value]) || empty($_POST[$value])) {
        sendAlert->Error(Language("fill-all-fields", "alert"), "report" . $Web['config']['php']);
    }
    $post[$value] = SCRIPTS->normalizar2($_POST[$value]);
}

$ruta = $Web['directorio'] . "report" . $Web['config']['php'] . '?r=' . $post['token-comentario'];

if (SCRIPTS->SimpleToken($_POST['resultado']) !== $_POST['resultado_verificar']) {
    sendAlert->Warning(Language("incorrect-sum", "alert"), $ruta);
}
$comentarios = [];
if (file_exists(DATA->CommentRoute())){ $comentarios = DATA->CommentAll(); }
if (count($comentarios) <= 0) {
    sendAlert->Error(Language("no-comments-yet", "alert"), "report" . $Web['config']['php']);
}
for ($i = 1; $i <= count($comentarios); $i++) {
    if (SCRIPTS->SimpleToken($i) == $post['token-comentario']) { $id = $i; $encontro = true; break; }
}
if (!isset($encontro)) {
    sendAlert->Error(Language("comment-to-report-not-exist", "alert"), "report" . $Web['config']['php']);
}

if ($comentarios[$id]['estado'] != 'publico') {
    header("Location: report{$Web['config']['php']}?r={$post['token-comentario']}");
}

$post['fecha'] = SCRIPTS->fecha_hora();

if (!file_exists(DATA->CommentRoute(true))) { DATA->Save(DATA->CommentRoute(true, false), []); }
$file_comentarios_extras_leer = DATA->Comment("extras");

$reportes = 1;
$conteo = 0;
if (isset($comentarios[$id]['reportes'])) { $reportes = count($comentarios[$id]['reportes']) + 1;
    foreach ($comentarios[$id]['reportes'] as $key => $value) {
        if ($value['id_usuario'] == $_SESSION['id']) {
            sendAlert->Warning(Language("report-already-sent", "alert"), $ruta);
        }
        $conteo++;
    }
}
$file_comentarios_extras_leer[$id]['reportes'][$reportes] = ['id_usuario' => $_SESSION['id'], 'motivos' => $post['motivos'], 'motivos_texto' => $post['motivos_texto'], 'fecha' => $post['fecha']];
$resultado = DATA->UpdateComment($file_comentarios_extras_leer, true);
if ($resultado) {
    if ($conteo % 3 == 0 && $conteo != 0) {
        $file_comentarios_extras_leer[$id]['estado'] = 'revision';
        DATA->UpdateComment($file_comentarios_extras_leer, true);
    }
    sendAlert->Success(Language("comment-reported", "alert"), $ruta);
}
sendAlert->Error(Language("failed-to-report-comment", "alert"), $ruta);