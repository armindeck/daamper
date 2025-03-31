<?php # 07/11/2024 ~ 12:04am | 30/03/2025 ~ 7:42pm
$Web['directorio'] = '../'; $Web['ruta'] = 'procesa/procesa.reportar.php';
require_once $Web['directorio'].'app/control/control_procesa.php';

if (!isset($_POST['reportar']) || !isset($_SESSION['id'])) {
    mensajeSpan(['bg'=>'yellow', 'co' => 'black',
        'text'=> Language("login-or-do-not-modify-hidden-fields", "alert"),
        'ruta'=>$Web['directorio']
    ]);
}

$lista = ['motivos', 'motivos_texto', 'token-comentario', 'resultado', 'resultado_verificar'];
foreach ($lista as $key => $value) {
    if (!isset($_POST[$value]) || empty($_POST[$value])) {
        mensajeSpan(['bg'=>'red',
            'text'=> Language("fill-all-fields", "alert"),
            'ruta'=>"reportar" . $Web['config']['php']
        ]);
    }
    $post[$value] = SCRIPTS->normalizar2($_POST[$value]);
}

$ruta = $Web['directorio'] . "reportar" . $Web['config']['php'] . '?r=' . $post['token-comentario'];

if (md5('R+_'. $_POST['resultado'] . '-W') !== $_POST['resultado_verificar']) {
    mensajeSpan(['bg'=>'yellow', 'co'=>'#000',
        'text'=> Language("incorrect-sum", "alert"),
        'ruta'=>$ruta
    ]);
}
$file_comentarios = $Web['directorio'] . AppDatabase('comentarios/comentarios');
$comentarios = 0;
if (file_exists($file_comentarios)){ $comentarios = require_once $file_comentarios; }
if (count($comentarios) <= 0) {
    mensajeSpan(['bg'=>'red',
            'text'=> Language("no-comments-yet", "alert"),
            'ruta'=>"reportar" . $Web['config']['php']
        ]);
}
for ($i = 1; $i <= count($comentarios); $i++) {
    if (md5('R+_' . $i . '-W') == $post['token-comentario']) { $id = $i; $encontro = true; break; }
}
if (!isset($encontro)) {
    mensajeSpan(['bg'=>'red',
        'text'=> Language("comment-to-report-not-exist", "alert"),
        'ruta'=>"reportar" . $Web['config']['php']
    ]);
}

if ($comentarios[$id]['estado'] != 'publico') {
    header("Location: reportar{$Web['config']['php']}?r={$post['token-comentario']}");
}

$post['fecha'] = SCRIPTS->fecha_hora();

$file_comentarios_extras = $Web['directorio'] . AppDatabase('comentarios/comentarios_extras');
if (!file_exists($file_comentarios_extras)) { file_put_contents($file_comentarios_extras, "<?php\n"); }
$file_comentarios_extras_leer = file_get_contents($file_comentarios_extras);

require $file_comentarios_extras;
$reportes = 1;
$conteo = 0;
if (isset($comentarios[$id]['reportes'])) { $reportes = count($comentarios[$id]['reportes']) + 1;
    foreach ($comentarios[$id]['reportes'] as $key => $value) {
        if ($value['id_usuario'] == $_SESSION['id']) {
            mensajeSpan(['bg'=>'yellow', 'co'=>'#000',
                'text'=> Language("report-already-sent", "alert"),
                'ruta'=>$ruta
            ]);
        }
        $conteo++;
    }
}
$dato = "$" . "comentarios[$id]['reportes'][$reportes] = ['id_usuario' => {$_SESSION['id']}, 'motivos' => '{$post['motivos']}', 'motivos_texto' => '{$post['motivos_texto']}', 'fecha' => '{$post['fecha']}'];\n";
$resultado = file_put_contents($file_comentarios_extras, $file_comentarios_extras_leer . $dato);
if ($resultado) {
    if ($conteo % 3 == 0 && $conteo != 0) {
        file_put_contents($file_comentarios_extras, file_get_contents($file_comentarios_extras
        ) . "$". "comentarios[$id]['estado'] = 'revision';\n");
    }
    mensajeSpan(['bg'=>'green',
        'text'=> Language("comment-reported", "alert"),
        'ruta'=>$ruta
    ]);
}
mensajeSpan(['bg'=>'red',
    'text'=> Language("failed-to-report-comment", "alert"),
    'ruta'=>$ruta
]);