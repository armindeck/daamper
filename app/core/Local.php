<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  Local.php                                                             */
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

class Local{

    protected static string $baseDB = __DIR__ . '/../../database/';

    /*
    protected static function update(string $file, array $data): array {
        $route = self::path($file);

        if(!file_exists($route)){
            return ["success" => false, "message" => "El archivo no existe.", "error_code" => 404];
        }

        $write = self::write($file, $data);

        if(!$write['success']){
            return ["success" => false, "message" => "Error al actualizar el archivo.", "error_code" => 500];
        }

        return ["success" => true, "message" => "El archivo se actualizó correctamente.", "error_code" => 200];
    }
    */

    protected static function write(string $file, array $data): array {
        $route = self::path($file);

        $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if($content === false){
            return ["success" => false, "message" => "Error al convertir los datos a JSON.", "error_code" => 500];
        }

        $write = file_put_contents($route, $content, LOCK_EX);
        if($write === false){
            return ["success" => false, "message" => "Error al escribir en el archivo.", "error_code" => 500];
        }

        return ["success" => true, "message" => "El archivo se escribió correctamente.", "error_code" => 200];
    }

    protected static function read(string $file): array{
        $route = self::path($file);

        if(!file_exists($route)){
            return ["success" => false, "message" => "El archivo no existe", "error_code" => 404];
        }

        $content = file_get_contents($route);

        if($content === false){
            return ["success" => false, "message" => "Error al leer el archivo.", "error_code" => 500];
        }

        $decode = json_decode($content, true);

        if($decode === null && json_last_error() !== JSON_ERROR_NONE){
            return ["success" => false, "message" => "Error al decodificar el JSON: " . json_last_error_msg(), "error_code" => 500];
        }

        return $decode ?? [];
    }

    protected static function path(string $file): string {
        $file = str_replace(".json", "", $file);
        return self::$baseDB . $file . ".json";
    }

    protected static function exists(string $file) : bool {
        return file_exists(self::path($file));
    }

    protected static function scan(string $folder): array {
        $dir = self::$baseDB . $folder;
        if (!is_dir($dir)) return [];
        $files = scandir($dir);
        return array_values(array_filter($files, fn($f) => !in_array($f, ['.', '..'])));
    }
}