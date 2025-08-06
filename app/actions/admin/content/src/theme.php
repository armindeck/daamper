<?php
if(file_exists($Web["directorio"]."database/theme/theme.json")){
    $Web['theme'] = Daamper::$data->Read("theme/theme") ?? [];
    if(isset($Web['theme']['tema']) && !empty($Web['theme']['tema']) && file_exists($Web["directorio"]."database/theme/".($Web['theme']['archivo']))){
        $Web['theme']['styles'] = Daamper::$data->Read("theme/" . $Web['theme']['archivo']) ?? [];
        if(isset($Web['theme']['styles'])){
            echo "<!-- Tema: ". (isset($Web['theme']['styles']['nombre_tema']) ? $Web['theme']['styles']['nombre_tema'] : 'Indefinido') . " -->\n<style type='text/css'>\n";
            foreach ($Web['theme']['styles'] as $key => $value) {
                if(!in_array($key, ['archivo', 'cantidad', 'nombre_tema', 'id'])) {
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