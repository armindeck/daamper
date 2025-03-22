<?php
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){
        $file = 'imagen';
        $file_nombre = $_FILES[$file]['name'];
        $file_tamano = $_FILES[$file]['size'];
        $file_tipo = $_FILES[$file]['type'];
        $file_error = $_FILES[$file]['error'];
        $file_tmp = $_FILES[$file]['tmp_name'];
        //echo "Nombre: $file_nombre<br>Tamaño: $file_tamano<br>Tipo: $file_tipo<br>Error: $file_error<br>Tmp: $file_tmp";
        if($file_error>0){
            mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['dashboard']['subir-imagen']['error-upload-image'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
         } else {
            if($file_tipo=='image/jpg' || $file_tipo=='image/jpeg' || $file_tipo=='image/png' || $file_tipo=='image/gif'){
                #$unMegabyteEnBytes = 1024 * 1024;
                #echo "Un megabyte equivale a: $unMegabyteEnBytes bytes";      
                if($file_tamano>1048576){
            		mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['dashboard']['subir-imagen']['image-max-size'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
                }{
                    $ubicacion_imagen = $Web['directorio'].'assets/img/';
                    $extension = pathinfo($file_nombre, PATHINFO_EXTENSION);

                    $_POST['imagen_nombre'] = SCRIPTS->normalizar(SCRIPTS->archivoAceptado($_POST['imagen_nombre']));
                    $nuevo_nombre = !empty($_POST['imagen_nombre']) ?
                    	SCRIPTS->normalizar(SCRIPTS->archivoAceptado($_POST['imagen_nombre'])) : $file_nombre;
                    $numero = 0;
                    $nombre_final = $nuevo_nombre;
                    //substr($nuevo_nombre, 0, -4);
                    $sin_extencion = rtrim($nombre_final, '.'.$extension);
                    $nombre_final = $sin_extencion.'.'.$extension;

                    while(file_exists($ubicacion_imagen.$nombre_final)){
                        $numero++;
                        $nombre_final = $sin_extencion . '_' . $numero .'.'. $extension;
                    }

                    move_uploaded_file($file_tmp, $ubicacion_imagen.$nombre_final);
                    mensajeSpan(['bg'=>'green','text'=>(LANGUAJE['dashboard']['subir-imagen']['uploaded-image'][CONFIG['languaje']]).': <a target="_blank" href="../assets/img/'.$nombre_final.'">'.(LANGUAJE['global']['show'][CONFIG['languaje']]).' <i class="fas fa-external-link-alt"></i></a>','ruta'=>"../panel.php?ap=$Apartado"]);
                }
            } else {
            	mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['dashboard']['subir-imagen']['format-accept'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
            }
        }
    } else {
        mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['dashboard']['subir-imagen']['error-uploading'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
    }

$DATOS_DEFAULT = false;
?>