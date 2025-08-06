<?php
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){
    $VERSION = Daamper::$version["components"]["upload-image"];
    if ($tipo_de_seccion == "auth"){ $Apartado = "auth"; }
    $ruta_mspan = [
        "admin" => "admin/admin".$Web["config"]["php"]."?ap=$Apartado",
        "auth" => "auth/config".$Web["config"]["php"]."?up=change-avatar"
    ];
    $ruta_mspan_exito = ["auth" => "p/perfil" . $Web["config"]["php"]];
    $ruta_a = $ruta_mspan[$tipo_de_seccion];
    $file = 'imagen';
    $file_nombre = $_FILES[$file]['name'];
    $file_tamano = $_FILES[$file]['size'];
    $file_tipo = $_FILES[$file]['type'];
    $file_error = $_FILES[$file]['error'];
    $file_tmp = $_FILES[$file]['tmp_name'];
    if($file_error>0){
        Daamper::$sendAlert->Error(Language(['upload-image', 'error-upload-image'], 'dashboard'), $Web["directorio"].$ruta_a);
    } else {
        $default_data = Daamper::$data->Config("default");
        if(in_array($file_tipo, $default_data["global"]["upload-image"]["support"])){
            #$unMegabyteEnBytes = 1024 * 1024 = 1048576; // 1mb
            #echo "Un megabyte equivale a: $unMegabyteEnBytes bytes";
            $peso_maximo_megas = $default_data[$tipo_de_seccion]["upload-image"]["max-size"] ?? 1; # ??mb or 1mb
            $peso_maximo_total = 1048576 * $peso_maximo_megas;
            if($file_tamano>$peso_maximo_total){
                Daamper::$sendAlert->Error(Language(['upload-image', 'image-max-size'], 'dashboard', ["value" => "{$peso_maximo_megas}mb"]), $Web["directorio"].$ruta_a);
            }{
                $ubicacion_imagen = $Web['directorio'].'assets/img/' . ($tipo_de_seccion == "auth" ? "avatar/" : "");
                $extencion_path = pathinfo($file_nombre, PATHINFO_EXTENSION);

                if ($tipo_de_seccion == "auth"){
                    $nombre_final = $usu[$_SESSION['id']]['usuario'].'.jpg';
                }
                if ($tipo_de_seccion == "admin"){
                    $_POST['imagen_nombre'] = Daamper::$scripts->normalizar(Daamper::$scripts->archivoAceptado($_POST['imagen_nombre'] ?? ''));
                    $nuevo_nombre = !empty($_POST['imagen_nombre']) ?
                        Daamper::$scripts->normalizar(Daamper::$scripts->archivoAceptado($_POST['imagen_nombre'])) : $file_nombre;
                    
                    $explode = explode(".", $nuevo_nombre);
                    var_dump(count($explode));
                    $extencion = count($explode) > 1 ? $explode[count($explode)-1] : $extencion_path;
                    $strlen = strlen($nuevo_nombre);
                    $sin_extencion = count($explode) > 1 ? substr($nuevo_nombre, 0, ($strlen - strlen($extencion) - 1)) : $nuevo_nombre;
                    $nombre_final = $sin_extencion . '.' . $extencion_path;
                    $numero = 0;
                    while(file_exists($ubicacion_imagen.$nombre_final)){
                        $numero++;
                        $nombre_final = $sin_extencion . '-' . $numero .'.'. $extencion_path;
                    }
                    //echo "Nombre path: {$file_nombre}<br>Nombre nuevo: {$nuevo_nombre}<br>Extencion path: $extencion_path<br>Sin Extencion: {$sin_extencion}<br>Nombre final: {$nombre_final}";
                    //die();
                }
                $ruta_a = isset($ruta_mspan_exito[$tipo_de_seccion]) ? $ruta_mspan_exito[$tipo_de_seccion] : $ruta_a;
                //echo $ruta_a;
                move_uploaded_file($file_tmp, $ubicacion_imagen.$nombre_final);
                Daamper::$sendAlert->Success(Language(['upload-image', 'uploaded-image'], 'dashboard') . (
                    $tipo_de_seccion == "admin" ?
                        ': <a target="_blank" href="../assets/img/'.$nombre_final.'">'.(Language('show')).' <i class="fas fa-external-link-alt"></i></a>'
                    : ''), $Web["directorio"].$ruta_a
                );
            }
        } else {
            Daamper::$sendAlert->Error(Language(['upload-image', 'format-accept'], 'dashboard'), $Web["directorio"].$ruta_a);
        }
    }
} else {
    Daamper::$sendAlert->Error(Language(['upload-image', 'error-uploading'], 'dashboard'), $Web["directorio"].$ruta_a);
}

$DATOS_DEFAULT = false;