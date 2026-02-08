<?php
/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  scripts.php                                                           */
/**************************************************************************/
/*                        This file is part of:                           */
/*                              daamper                                   */
/*                 https://github.com/armindeck/daamper                   */
/**************************************************************************/
/* Copyright (c) 2025 DBHS / daamper                                      */
/*                                                                        */
/* Se concede permiso, de forma gratuita, a cualquier persona para usar,  */
/* modificar y ejecutar el código fuente de este software, incluyendo su  */
/* uso en proyectos comerciales (como monetización por publicidad o       */
/* donaciones).                                                           */
/*                                                                        */
/* Restricciones estrictas:                                               */
/* - No está permitido vender, sublicenciar o distribuir el código        */
/*   fuente —total o parcialmente— con fines de lucro.                    */
/* - No está permitido convertir el código en privativo ni eliminar       */
/*   esta licencia.                                                       */
/* - No está permitido reclamar la autoría del código original.           */
/*                                                                        */
/* Uso permitido:                                                         */
/* - Se permite modificar y usar el código con fines personales,          */
/*   educativos y/o comerciales, siempre que no se venda.                 */
/* - Se permite usar este software como base para otros proyectos,        */
/*   siempre que esta licencia se mantenga.                               */
/*                                                                        */
/* El autor (DBHS / daamper) se reserva el derecho de modificar esta      */
/* licencia en futuras versiones del software.                            */
/*                                                                        */
/* EL SOFTWARE SE ENTREGA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO,       */
/* EXPRESAS O IMPLÍCITAS, INCLUYENDO, SIN LIMITACIÓN, GARANTÍAS DE        */
/* COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO           */
/* INFRACCIÓN. EN NINGÚN CASO LOS AUTORES SERÁN RESPONSABLES POR          */
/* RECLAMACIONES, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN   */
/* CONTRACTUAL, EXTRACONTRACTUAL O DE OTRO TIPO, DERIVADAS DE O EN        */
/* CONEXIÓN CON EL SOFTWARE, SU USO O OTRO TIPO DE MANEJO.                */
/**************************************************************************/

class Scripts
{
    public function zona()
    {
        date_default_timezone_set('America/Bogota');
    }
    public function fecha()
    {
        $this->zona();
        return date('d/m/Y');
    }
    public function fecha_hora()
    {
        $this->zona();
        return date('d/m/Y - g:ia');
    }
    public function anio()
    {
        $this->zona();
        return date('Y');
    }
    public function normalizar($valor)
    {
        $valor = $this->convertirSimbolos($valor);
        //$valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripcslashes($valor);
        return $valor;
    }
    public function normalizar2($valor)
    {
        $valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripcslashes($valor);
        return $valor;
    }
    public function convertirSimbolos($valor)
    {
        $valor = str_replace('<', '&lt;', $valor);
        $valor = str_replace('>', '&gt;', $valor);
        $valor = str_replace('"', '&quot;', $valor);
        $valor = str_replace("'", '&#039;', $valor);
        $valor = str_replace('{', '&#123;', $valor);
        $valor = str_replace('}', '&#125;', $valor);
        return $valor;
    }
    public function quitarComilla($valor)
    {
        return $valor = str_replace("'", '&#039;', $valor);
    }
    public function sinEPHP($valor)
    {
        return $valor = str_replace(".php", '', $valor);
    }
    public function eslasToGuion($valor)
    {
        return str_replace('/', '-', $valor);
    }
    public function darFormatoNoSimbolos($string)
    {
        $string = str_replace(array('☺', '☻', '♥', '♦', '♣', '♠', '•', '◘', '○', '◙', '♂', '♀', '♪', '♫', '☼', '►', '◄', '↕', '‼', '¶', '§', '▬', '↨', '↑', '↓', '→', '←', '∟', '↔', '▲', '▼', '!', '"', '#', '$', '%', '&', '(', ')', '*', '+', ',', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '`', '{', '|', '}', '~', '⌂', 'ª', 'º', '¿', '®', '¬', '½', '¼', '¡', '«', '»', '░', '▒', '▓', '│', '┤', '©', '╣', '║', '╗', '╝', '¢', '¥', '┐', '└', '‼', '┴', '┬', '├', '─', '┼', '╚', '╔', '╩', '╦', '╠', '═', '╬', '¤', 'ð', '┘', '┌', '█', '▄', '¦', '▀', '¯', '´', '±', '³', '²', '¶', '§', '÷', '¸', '°', '¨', '·', '¹', '³', '²', '■', "'", '“', '”', '-', '/'), '', $string);
        return $string;
        #SOLO PASA  GUION BAJO "_", '.'
    }
    public function darFormatoNoSimbolosRuta($string)
    {
        $string = str_replace(array('☺', '☻', '♥', '♦', '♣', '♠', '•', '◘', '○', '◙', '♂', '♀', '♪', '♫', '☼', '►', '◄', '↕', '‼', '¶', '§', '▬', '↨', '↑', '↓', '→', '←', '∟', '↔', '▲', '▼', '!', '"', '#', '$', '%', '&', '(', ')', '*', '+', ',', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '`', '{', '|', '}', '~', '⌂', 'ª', 'º', '¿', '®', '¬', '½', '¼', '¡', '«', '»', '░', '▒', '▓', '│', '┤', '©', '╣', '║', '╗', '╝', '¢', '¥', '┐', '└', '‼', '┴', '┬', '├', '─', '┼', '╚', '╔', '╩', '╦', '╠', '═', '╬', '¤', 'ð', '┘', '┌', '█', '▄', '¦', '▀', '¯', '´', '±', '³', '²', '¶', '§', '÷', '¸', '°', '¨', '·', '¹', '³', '²', '■', "'", '“', '”', '.'), '', $string);
        return $string;
        #SOLO PASA  GUION BAJO "_", '-', '/'
    }
    public function sinEspacios($string)
    {
        $string = str_replace(' ', '-', $string);
        return $string;
    }
    public function sinAcentos($string)
    {
        $string = str_replace('á', 'a', $string);
        $string = str_replace('Á', 'A', $string);
        $string = str_replace('é', 'e', $string);
        $string = str_replace('É', 'E', $string);
        $string = str_replace('í', 'i', $string);
        $string = str_replace('Í', 'I', $string);
        $string = str_replace('ó', 'o', $string);
        $string = str_replace('Ó', 'O', $string);
        $string = str_replace('ú', 'u', $string);
        $string = str_replace('Ú', 'U', $string);
        return $string;
    }
    public function sinEnes($string)
    {
        $string = str_replace('ñ', 'n', $string);
        $string = str_replace('Ñ', 'N', $string);
        return $string;
    }
    public function quitarEPHP($string)
    {
        return str_replace('.php', '', $string);
    }
    public function quitarPuntoEslas($string)
    {
        $string = str_replace('../', '', $string);
        return str_replace('./', '', $string);
    }
    public function xv(string $apartado, string $other = null, string $simple = null)
    {
        $return = '';
        foreach (['version', 'state', 'updated'] as $value) {
            if (empty($other)) {
                $return .= Daamper::$version['dashboard'][$apartado][$value] . ' ';
            } else {
                $return .= Daamper::$version['dashboard'][$apartado]['other'][$value] . ' ';
            }
        }

        /*
        foreach ($XVERSION as $key => $value) {
            $leer .= file_get_contents((is_string($ubi) ? $ubi : $ubi[0]).'/x/'.$value.'.x').' ';
        }
        */

        if ($simple === null) {
            return '<p class="t-12">v' . $return . '</p>';
        }
        return $return;
    }
    public function version (array $list = ["dashboard", "creator", "other", "normal"]) : string {
        $show = [];
        if($list){
            $count = count($list);
            if($count == 1) { $show = Daamper::$version[$list[0]]; }
            if($count == 2) { $show = Daamper::$version[$list[0]][$list[1]]; }
            if($count == 3) { $show = Daamper::$version[$list[0]][$list[1]][$list[2]]; }
            if($count == 4) { $show = Daamper::$version[$list[0]][$list[1]][$list[2]][$list[3]]; }
        }
        $return = '';
        foreach (['version', 'state', 'updated', 'created'] as $v) {
            $return .= $show[$v] ? ($v == 'created' ? '- ' : '') . ($v == "state" ? Language(strtolower($show["state"])) : $show[$v]) . ' ' : '';
        }
        return $return ?? '';
    }
    public function RutaConvertir($string)
    {
        $string = trim($string);
        $string = $this->sinEspacios($string);
        $string = $this->darFormatoNoSimbolosRuta($string);
        $string = $this->sinEnes($string);
        $string = $this->sinAcentos($string);
        $string = strtolower($string);
        return $string;
    }
    public function archivoAceptado($string)
    {
        $method = '-_--pu_nto--_-';
        $string = str_replace('.', $method, $string);
        $string = $this->eslasToGuion($string);
        $string = $this->RutaConvertir($string);
        return str_replace($method, '.', $string);
    }
    public function rutaAceptada($string)
    {
        return $this->RutaConvertir($string);
    }
    public function Commands($string)
    {
        require __DIR__ . '/commands.php';
        return $string;
    }
    public function saltoToBr($string)
    {
        # REEMPLAZAR EL \N POR <BR>
        $string = preg_replace('/(\n{3,})/', "\n\n", $string);
        $string = str_replace("\n", "<br>", $string);
        $string = str_replace("<br>[/n]", '', $string);
        return $string;
    }
    public function espacios_left($string)
    {
        return str_replace("  ", '<i style="margin-left: 8px;"></i>', $string);
    }
    public function fechasInputDate(string $string)
    {
        $convertir = explode("-", $string);
        $convertir_texto = match (true) {
            $convertir[1] == "01" => 'Enero',
            $convertir[1] == "02" => 'Febrero',
            $convertir[1] == "03" => 'Marzo',
            $convertir[1] == "04" => 'Abril',
            $convertir[1] == "05" => 'Mayo',
            $convertir[1] == "06" => 'Junio',
            $convertir[1] == "07" => 'Julio',
            $convertir[1] == "08" => 'Agosto',
            $convertir[1] == "09" => 'Septiembre',
            $convertir[1] == "10" => 'Octubre',
            $convertir[1] == "11" => 'Noviembre',
            $convertir[1] == "12" => 'Diciembre',
            default => 'indefinido',
        };
        if (substr($convertir[2], 0, 1) == 0) {
            $convertir[2] = substr($convertir[2], 1, strlen($convertir[2]));
        }
        return "{$convertir[2]} de {$convertir_texto} del {$convertir[0]}";
    }

    public function DataPHPtoJSON(string $file, string $type = "post")
    {

        $route = match (true) {
            $type == "post" => "publicaciones/",
            $type == "user" => "usuarios/",

            default => ""
        };

        $filePath = __DIR__ . "/../database/{$route}" . ($type == "post" ? "pu_" : "") . "$file.php";
        $isPosts = false;
        if (!file_exists($filePath)) {
            $die = true;
            if ($type == "post" && file_exists(str_replace("pu_", "", $filePath))) {
                $filePath = str_replace("pu_", "", $filePath);
                $isPosts = true;
                $die = false;
            }

            if ($die) {
                die("No existe: <strong>$file</strong>");
            }
        }

        if ($type == "post" && $isPosts) {
            $data = require $filePath;
        } else {
            require $filePath;

            if ($type == "post") {
                $data = array_merge(["ACR" => $ACR ?? []], ["AC" => $AC ?? []]);
            } elseif ($type == "user") {
                $data = $usu ?? [];
            }
        }

        $newRoute = match (true) {
            $type == "post" => "post/",
            $type == "user" => "user/",
        };

        CrearCarpetas("database/$newRoute");

        $newNameFile = match (true) {
            $file == "usuarios" => "user",
            $file == "usuarios_extras" => "extras",
            default => $file
        };

        return file_put_contents(__DIR__ . "/../../database/{$newRoute}{$newNameFile}.json", json_encode($data) ?? []);
    }

    public function DataPHPtoJSONAll(array $routes = null)
    {
        $routes = $routes === null ? ["publicaciones" => "post", "usuarios" => "user"] : $routes;
        $confirmar = [];
        foreach ($routes as $key => $value) {
            $files = glob(__DIR__ . "/../database/$key/*");
            foreach ($files as $key2 => $value2) {
                $file = str_replace(["pu_", ".php"], "", basename($value2));
                $confirmar[$key][$value2] = $this->DataPHPtoJSON($file, $value);
            }
        }
        return $confirmar;
    }

    public function PostNewPost(string $file){
        $file = "pu_" . str_replace([".php", "pu_"], "", basename($file)) . ".php";
        $route = __DIR__."/../database/publicaciones/$file";
        if (!file_exists($route)){ return false; }
        require $route;
        $ACR["db_archivo"] = str_replace(["pu_", "bo_", ".php"], "", $ACR["db_archivo"]). ".json";
        $data = ["ACR" => $ACR, "AC" => $AC];
        $file = str_replace([".php", "pu_"], "", $file) . ".json";
        return file_put_contents(__DIR__."/../../database/post/$file", json_encode($data));
    }

    public function PostNewPostAll(){
        $files = glob(__DIR__."/../database/publicaciones/pu_*", GLOB_BRACE);
        foreach ($files as $file) {
            $this->PostNewPost($file);
            echo "$file<br>";
            require $file;
            $this->CreateEntry($AC["ruta"].$AC["archivo"], $AC["directorio"]);
        }
        $files = glob(__DIR__."/../database/publicaciones/publicaciones*", GLOB_BRACE);
        foreach ($files as $file) {
            $leer = require $file;
            file_put_contents(__DIR__."/../../database/post/entries/" . str_replace(".php", "", basename($file)) . ".json", json_encode($leer));
        }
    }

    public function CreateEntry(string $route, string $directorio = "./"){
        $dir = __DIR__."/../../";
        $directorios = dirname($route) . "/";
        $explode = explode("/", $route);
        if (in_array($explode[0], ["app", "database", "assets", "process"])){
            return;
        }
        if(isset($explode[1])){
            if($explode[0] . "/" . $explode[1] == "admin/process"){ die("noooo"); return; }
        }
        if (!file_exists($dir.$directorios)){
            $this->CrearCarpetas($directorios);
        }
        $route = str_replace(".php", "", $route) . ".php";

        $guardar = '<?php # ' . $this->fecha_hora() . "\n";
        $guardar .= '$Web'." = ['directorio'=>'$directorio','ruta'=>'$route'];\n";
        $guardar .= "require_once ".'$Web'."['directorio'].'app/controller/controller.php';";
        return file_put_contents($dir.$route, $guardar);
    }

    public function UnirArrays(array $primary, array $secundary)
    {
        foreach ($secundary as $key => $value) {
            $primary[$key] = array_merge($primary[$key], $value);
        }
        return $primary;
    }

    public function Password(string $pass, bool $md5 = false)
    {
        return $md5 ? md5($pass) : password_hash($pass, PASSWORD_DEFAULT);
    }

    public function PasswordVerify(string $pass, string $consult, bool $md5 = false)
    {
        return $md5 ? $this->Password($pass) === $consult : password_verify($pass, $consult);
    }

    public function CrearCarpetas(string $ruta, bool $raiz = true)
    {
        if ($ruta[-1] != '/') {
            $ruta .= '/';
        }
        $ruta = $raiz ? __DIR__ . "/../../$ruta" : $ruta;
        if (!file_exists($ruta)) {
            if (mkdir($ruta, 0777, true));
        }
    }
    public function is_par_letras($numero){
        $letras = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "K", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        //$letras = ['A','E','I','O','U'];
        return ($numero % 2 == 0) ? $letras[rand(0, count($letras)-1)] : $numero;
    }
    public function GenerarPin(array $cantidad = [4, 5, 7]){
        $numeros = '';
        foreach ($cantidad as $key => $valor) {
            $numeros .= $key >= 1 ? '-' : '';
            for($i=0; $i < $valor; $i++){
                $numeros .= $this->is_par_letras(rand(0,9));
            }
        }
        return $numeros;
    }
    function limpiarTextoPlano(string $string) {
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string); // sin signos, emojis
        return preg_replace('/\s+/', ' ', $string);
    }
    public function SimpleSuma(){
        $file = RAIZ . "database/config/default.json";
        $quantity = ["min" => 1, "max" => 15, "min-input" => 1, "max-input" => 99];
        if(file_exists($file) && !empty(file_get_contents($file))){
            $leer = json_decode(file_get_contents($file), true);
            if(isset($leer["global"]["simple-suma"]) && !empty($leer["global"]["simple-suma"])){
                $quantity = $leer["global"]["simple-suma"];
            }
        }
        $a = rand($quantity["min"], $quantity["max"]);
        $b = rand($quantity["min"], $quantity["max"]);
        $c = $a + $b;
        return ["a" => $a, "b" => $b, "c" => $c, "min-input" => $quantity["min-input"], "max-input" => $quantity["max-input"]];
    }
    public function SimpleToken(string $string){
        return md5('R+_'. $string . '-W');
    }
    public function GenerateToken(){
        return bin2hex(random_bytes(16));
    }
    public function hash(string $route, string $text = null, int $id_user = null){
        return md5($route . ($text != null ? "|" . $this->limpiarTextoPlano($text) : "") . ($id_user != null ? "|" . $id_user : ""));
    }
    
    public function optenerTemas(string $urlCss, bool $all = false) : array {
        $css = file_get_contents($urlCss);
        preg_match_all('/\[data-theme="([^"]+)"\]/', $css, $matches);

        if(!$all && !empty($matches)){
            $matches = $matches[1];
        }

        return $matches ?? [];
    }

    public function readDirectory(string $directory = "", array $list = ["files" => "php,js,json,css,html,png,jpg,jpeg,gif,ico,txt,md", "show" => "route|basename", "extension" => "true|true", "type" => false]): array {
        $dir = RAIZ . $directory;

        $show = $list["show"] ?? "route|basename"; // route|basename - route|route - basename|basename
        $extension = $list["extension"] ?? "true|true"; // true|true - false|false - true|false - false|true

        $files = glob("{$dir}*". (!empty($list["files"]) ? ".{{$list['files']}}" : ""), GLOB_BRACE);
	    sort($files, SORT_NATURAL | SORT_FLAG_CASE);

        $return = (array) [];

        foreach ($files as $file) {
            $is_dir = is_dir($file);
            $file = str_replace(RAIZ, "", $file);
            $file .= $is_dir ? "/" : "";
            $value = [];

            $type = $is_dir ? "folder" : pathinfo($file, PATHINFO_EXTENSION);

            switch ($show) {
                case 'route|basename': $value[0] = $file; $value[1] = basename($file); break;
                case 'route|route': $value[0] = $file; $value[1] = $file; break;
                case 'basename|basename': $value[0] = basename($file); $value[1] = basename($file); break;
                default: return ["Error: show incorrecto" => "Error: show incorrecto"]; break;
            }

            switch ($extension) {
                case 'false|false': $value[0] = substr($value[0], 0, strrpos($value[0], ".")); $value[1] = substr($value[1], 0, strrpos($value[1], ".")); break;
                case 'false|true': $value[0] = substr($value[0], 0, strrpos($value[0], ".")); break;
                case 'true|false': $value[1] = substr($value[1], 0, strrpos($value[1], ".")); break;
                case 'true|true': break;
                default: return ["Error: valor de mostrar extencion incorrecta" => "Error: valor de mostrar extencion incorrecta"]; break;
            }

            if(!empty($list["type"])){
                $return[$value[0]] = [0 => $value[1], "type" => $type];
            } else {
                $return[$value[0]] = $value[1];
            }
        }

        return $return;
    }
}
Daamper::$scripts = new Scripts;

foreach (
    [
        'send-alert',
        'input',
        'function'
    ] as $key => $value
) {
    require_once __DIR__ . "/$value.php";
}
