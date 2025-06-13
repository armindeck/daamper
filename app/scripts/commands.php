<?php /* Commands
CMD (Commands)
	cmd[version]; → 0.0.0 | Versión actual
	cmd[state]; → Stable | Estado actual
	cmd[updated]; → 00.00.0000 | Fecha de actualización actual
	cmd[created]; → 12.06.2024 | Fecha de creación
	cmd[license]; → Licencia oficial o texto corto de la licencia
	cmd[author]; → Armin
	cmd[author-page-name]; → dbproject
	cmd[author-page-link]; → https://dbproject.rf.gd
	cmd[creator-social-networks]; → Bucle → <a target="_blank" href="LINK"><i class="ICON"></i> NAME</a>
	cmd[directory]; → ./ | ../ | Directorio que se mostrara en la publicación
	cmd[directory_image_complete]; → https://.com/assets/img/ | ./assets/img/ | Se mostrara el directorio/enlace de la pagina con el directorio de las imagenes. 
*/
global $Web;
$commands = DATA->Config("commands");

$text_social = "";
foreach (INFO["social-networks"] as $key => $value) {
	$text_social .= "link-external[{$value['link']}]/[icon[{$value['icono']}]icon; {$value['name']}]link; ";
}

$cmd = [
	"cmd[version];" => VERSION["system"]["version"],
	"cmd[state];" => VERSION["system"]["state"],
	"cmd[updated];" => VERSION["system"]["updated"],
	"cmd[created];" => VERSION["system"]["created"],
	"cmd[license];" => file_exists(RAIZ . "license.txt") ? str_replace("\n", "<br>", file_get_contents(RAIZ . "LICENSE.txt")) : VERSION["system"]["license"],
	"cmd[creator];" => INFO["author"],
	"cmd[creator-page-name];" => INFO["author-page-name"],
	"cmd[creator-page-link];" => INFO["author-page-url"],
	"cmd[creator-social-networks];" => strtr($text_social, $commands),
	"cmd[directory];" => $Web["directorio"],
	"cmd[directory_image_complete];" => (isset($Web['config']['https_imagen']) ? $Web['config']['https_imagen'] : '') . 'assets/img/'
];

foreach (array_merge($commands, $cmd) as $key => $value) {
	// Ignorar comandos
	if (substr($key, -4, strlen($key)) != "http") {
		$string = str_replace(
			"`$key`",
			$key[-1] == "[" ? (substr($key, 0, strlen($key) - 1) . "`.[") : ($key[-1] == ";" ? (substr($key, 0, strlen($key) - 1) . "`.;") : (
					substr($key, -2, strlen($key)) == "-`" ? substr($key, 0, strlen($key) - 1) . "|.→" : $key
				)),
			$string
		);
	}

	// Convertir contenido de la imagen local
	if ($key == "img[") {
		$value .= "cmd[directory_image_complete];";
	}

	// Convertir comandos
	$string = str_replace($key, $value, $string);

	// Restaurar comandos ignorados
	$string = str_replace(substr($key, 0, strlen($key) - 1) . "`.[", $key, $string);
	$string = str_replace(substr($key, 0, strlen($key) - 1) . "`.;", $key, $string);
	$string = str_replace(substr($key, 0, strlen($key) - 1) . "|.→", $key, $string);
}
