<?php # 23/03/2025
$Web['directorio'] = '../'; $Web['ruta'] = 'process/report.php';
require_once $Web['directorio'].'app/controller/admin.php';

if (!isset($_POST['reportar']) || !isset($_SESSION['id'])) {
    Daamper::$sendAlert->Warning(Language("login-or-do-not-modify-hidden-fields", "alert"), $Web['directorio']);
}

$lista = ['motivos', 'motivos_texto', 'token-comentario', 'resultado', 'resultado_verificar'];
foreach ($lista as $key => $value) {
    if (!isset($_POST[$value]) || empty($_POST[$value])) {
        Daamper::$sendAlert->Error(Language("fill-all-fields", "alert"), "report" . $Web['config']['php']);
    }
    $post[$value] = Daamper::$scripts->normalizar2($_POST[$value]);
}

$ruta = $Web['directorio'] . "report" . $Web['config']['php'] . '?r=' . $post['token-comentario'];

if (Daamper::$scripts->SimpleToken($_POST['resultado']) !== $_POST['resultado_verificar']) {
    Daamper::$sendAlert->Warning(Language("incorrect-sum", "alert"), $ruta);
}
$comentarios = [];
if (file_exists(Daamper::$data->CommentRoute())){ $comentarios = Daamper::$data->CommentAll(); }
if (count($comentarios) <= 0) {
    Daamper::$sendAlert->Error(Language("no-comments-yet", "alert"), "report" . $Web['config']['php']);
}
for ($i = 1; $i <= count($comentarios); $i++) {
    if (Daamper::$scripts->SimpleToken($i) == $post['token-comentario']) { $id = $i; $encontro = true; break; }
}
if (!isset($encontro)) {
    Daamper::$sendAlert->Error(Language("comment-to-report-not-exist", "alert"), "report" . $Web['config']['php']);
}

if ($comentarios[$id]['estado'] != 'publico') {
    header("Location: report{$Web['config']['php']}?r={$post['token-comentario']}");
}

$post['fecha'] = Daamper::$scripts->fecha_hora();

if (!file_exists(Daamper::$data->CommentRoute(true))) { Daamper::$data->Save(Daamper::$data->CommentRoute(true, false), []); }
$file_comentarios_extras_leer = Daamper::$data->Comment("extras");

$reportes = 1;
$conteo = 0;
if (isset($comentarios[$id]['reportes'])) { $reportes = count($comentarios[$id]['reportes']) + 1;
    foreach ($comentarios[$id]['reportes'] as $key => $value) {
        if ($value['id_usuario'] == $_SESSION['id']) {
            Daamper::$sendAlert->Warning(Language("report-already-sent", "alert"), $ruta);
        }
        $conteo++;
    }
}
$file_comentarios_extras_leer[$id]['reportes'][$reportes] = ['id_usuario' => $_SESSION['id'], 'motivos' => $post['motivos'], 'motivos_texto' => $post['motivos_texto'], 'fecha' => $post['fecha']];
$resultado = Daamper::$data->UpdateComment($file_comentarios_extras_leer, true);
if ($resultado) {
    if ($conteo % 3 == 0 && $conteo != 0) {
        $file_comentarios_extras_leer[$id]['estado'] = 'revision';
        Daamper::$data->UpdateComment($file_comentarios_extras_leer, true);
    }
    Daamper::$sendAlert->Success(Language("comment-reported", "alert"), $ruta);
}
Daamper::$sendAlert->Error(Language("failed-to-report-comment", "alert"), $ruta);