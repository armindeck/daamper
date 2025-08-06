<?php # api
Ruta(null, "./api.php", function () use ($Web) {
    header('Content-Type: application/json');
    if(isset($Web["config"]["api"]) && !empty($Web["config"]["api"])){
        $show = [];
        $read = Daamper::$data->Config("default");
        foreach ($read["api"]["show"] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if(isset(($Web["config"]["show-api-$key-$value2"])) && !empty($Web["config"]["show-api-$key-$value2"])){
                    $show[$key][$value2] = Daamper::$data->Read($key."/".$value2);
                }
            }
        }
        foreach ($read["api"]["auto"] as $key => $value) {
            if(isset(($Web["config"]["show-api-auto-$value"])) && !empty($Web["config"]["show-api-auto-$value"])){
                $files = glob(RAIZ . "database/$value/*.json", GLOB_BRACE);
                foreach ($files as $key => $file) {
                    $leer = Daamper::$data->Read($value."/". basename($file));
                    if(in_array($value, ["post", "draft"])){
                        $route = str_replace(".php", "", $leer["AC"]["ruta"].$leer["AC"]["archivo"]);
                        $show[$value][$route] = $leer;
                    } else {
                        $route = str_replace(".json", "", basename($file));
                        $show[$value][$route] = $leer;
                    }
                }
            }
        }
        die(json_encode($show));
    } else {
        die(json_encode([]));
    }
});