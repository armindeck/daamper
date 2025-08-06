<?php $LISTA_DATOS_POST=['id_comentario','estado_comentario'];

foreach ($LISTA_DATOS_POST as $key => $value) {
    if(!isset($_POST[$value]) || empty($_POST[$value])){
        Daamper::$sendAlert->Error(Language("do-not-modify-hidden-fields", "alert"), "../admin.php?ap=$Apartado");
    }
}

if(!file_exists(Daamper::$data->CommentRoute()) || empty(Daamper::$data->Comment())){
    Daamper::$sendAlert->Error(Language("no-comments-yet", "alert"), "../admin.php?ap=$Apartado");
}

foreach (Daamper::$data->CommentAll() as $key => $value) {
    if($_POST["id_comentario"] == Daamper::$scripts->hash($value["ruta"], $value["comentario"], $value["id"])){
        $id = $value["id"];
    }
}

if(!isset($id) || !in_array($_POST["estado_comentario"], ["publico", "revision", "eliminado"])){
    Daamper::$sendAlert->Error(Language("do-not-modify-hidden-fields", "alert"), "../admin.php?ap=$Apartado");
}
$comments = Daamper::$data->Comment("extras");
$comments[$id]["estado"] = Daamper::$scripts->normalizar($_POST["estado_comentario"]);
$confirmar = Daamper::$data->UpdateComment($comments, true);

function Historial($status = false) {
	$file = RAIZ . "database/files/txt/history/comments.txt";
	if (!file_exists($file)) { file_put_contents($file, 'Generado: ' . Daamper::$scripts->fecha_hora()); }
	$leer = file_get_contents($file);
	$guardar = Daamper::$scripts->fecha_hora() . ' ~ '.($status ? 'Modificado' : 'Fallo').' → ' . $_SESSION['id'];
	file_put_contents($file, "$guardar\n$leer");
}

if(!$confirmar){
	Historial(false);
	Daamper::$sendAlert->Error(Language('data-no-save'), "../admin.php?ap=$Apartado");
}

Historial(true);
Daamper::$sendAlert->Success(Language('data-save'), "../admin.php?ap=$Apartado");

$DATOS_DEFAULT = false;