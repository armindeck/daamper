<?php $AC_DIRECTORIO = '../';
    function archivoAceptado($string){
        $string = str_replace('/','-',$string);
        return $string;
    }
    function normalizar($valor){
        $valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripcslashes($valor);
        return $valor;
    }
    function error($string, $direccion = false){
        die('<h3>'.$string . '</h3><br><a style="padding: 8px; color:white; background:#484848; border-radius:4px; text-decoration:none;" href="../'.($direccion != false ? $direccion : 'auth/configuracion.php?up=actualizar_datos_avatar').'">Volver</a>');
        exit;
    };
    if(isset($_GET['s'])){
        error('Se subio la imagen: ' . normalizar($_GET['s']),'panel/panel.php?apartado=pagina-subir_imagen&dir=../assets/img/'.normalizar($_GET['s']));
        exit;
    }
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){
        $file = 'imagen';
        $file_nombre = $_FILES[$file]['name'];
        $file_tamano = $_FILES[$file]['size'];
        $file_tipo = $_FILES[$file]['type'];
        $file_error = $_FILES[$file]['error'];
        $file_tmp = $_FILES[$file]['tmp_name'];
        //echo "Nombre: $file_nombre<br>Tamaño: $file_tamano<br>Tipo: $file_tipo<br>Error: $file_error<br>Tmp: $file_tmp";
        if($file_error>0){ 
            error('Parece que hubo un error2');
         } else {
            if($file_tipo=='image/jpg' || $file_tipo=='image/jpeg' || $file_tipo=='image/png' || $file_tipo=='image/gif'){
                #$unMegabyteEnBytes = 1024 * 1024;
                #echo "Un megabyte equivale a: $unMegabyteEnBytes bytes";      
                if($file_tamano>1048576){
                    error('El tamaño maximo es de 1mb');
                }{
                    $ubicacion_imagen = $AC_DIRECTORIO.'assets/img/avatar/';
                    $_POST['imagen_nombre'] = normalizar(archivoAceptado($_POST['imagen_nombre']));
                    $nuevo_nombre = $usu[$_SESSION['id']]['usuario'].'.jpg';
                    $numero = 0;
                    $nombre_final = $nuevo_nombre;
                    $sin_extencion = substr($nuevo_nombre, 0, -4);
                    $extension = '.'.pathinfo($nuevo_nombre, PATHINFO_EXTENSION);
                    move_uploaded_file($file_tmp, $ubicacion_imagen.$nombre_final);
                    header("Location: procs_img.php?s=$nombre_final");
                }
            } else {
                error('Solo se acceptan formatos: jpg, jpeg, png y gif');
            }
        }
    } else {
        error('Parece que hubo un error');
    }
?>