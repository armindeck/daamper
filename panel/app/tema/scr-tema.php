<?php
if(file_exists(__DIR__.'/web-tema.php')){
    require __DIR__.'/web-tema.php';
    if(isset($Web['tema']['tema']) && !empty($Web['tema']['tema']) && file_exists(__DIR__.'/temas/'.($Web['tema']['archivo']))){
        require_once __DIR__.'/temas/'.($Web['tema']['archivo']);
        if(isset($Web['tema']['styles'])){
            echo "<!-- Tema: ". (isset($Web['tema']['styles']['nombre_tema']) ? $Web['tema']['styles']['nombre_tema'] : 'Indefinido') . " -->\n<style type='text/css'>\n";
            foreach ($Web['tema']['styles'] as $key => $value) {
                if($key != 'archivo' && $key != 'cantidad' && $key != 'nombre_tema' && $key != 'id') {
                    if(!empty($value['class']) || !empty($value['otros'])){
                        if(!empty($value['class'])){
                            echo $value['class'] . " {\n";
                            echo !empty($value['co']) ? 'color: ' . $value['co'] . " !important;\n" : '';
                            echo !empty($value['bg']) ? 'background-color: ' . $value['bg'] . " !important;\n" : '';
                            echo !empty($value['br']) ? 'border-radius: ' . $value['br'] . " !important;\n" : '';
                            echo !empty($value['pd']) ? 'padding: ' . $value['pd'] . " !important;\n" : '';
                            echo !empty($value['mr']) ? 'margin: ' . $value['mr'] . " !important;\n" : '';
                        }
                        echo !empty($value['otros']) ? $value['otros']."\n" : '';
                        if(!empty($value['class'])){ echo "}\n"; }
                    }
                }
            }
            echo "</style>\n";
        }
    }
}

?>