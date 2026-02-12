<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  juego-view.php                                                        */
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

require RAIZ . "app/actions/admin/content/global/creators/script/juego.php";

$optional_text = Language("optional");
$images_text = Language("images");
$gallery_text = Language("gallery");
$extras_text = Language("extras");
$minimum_requirements_text = Language("minimum-requirements");
$recommended_requirements_text = Language("recommended-requirements");
$downloads_text = Language("downloads");


$return .= pInput(['name' => 'titulo', 'type' => 'text', 'placeholder' => Language(['creator', 'name-of-the-game'], 'dashboard'), 'label' => false, 'texto' => Language(['creator', 'name-of-the-game'], 'dashboard'), 'required' => true]) .
	"<small>" . Language("markdown-is-supported") . "</small>";

$return .= pTextarea(['name'=>'sinopsis','placeholder'=>Language(['synopsis']),'label'=>false,'texto'=>Language(['synopsis']),'style'=>'min-height:100px','required'=>true]);

$optional_names = pTextarea(['name' => 'otros_nombres', 'placeholder' => 'My Game Run, ShooterSpaces...', 'label' => true, 'texto' => Language('other-names'), 'style' => 'min-height: 50px']).
	pTextarea(['name' => 'informacion_extra', 'placeholder' => Language(['creator', 'other', 'juego', 'extra-information-placeholder'], 'dashboard'), 'label' => true, 'texto' => Language('extra-information'), 'style' => 'min-height: 100px']);


$return .= <<<HTML
<details class="sub_container">
	<summary>$optional_text</summary>
	<section class="flex-column">$optional_names</section>
</details>
HTML;

foreach (['os' => $lista_os, 'genre' => $lista_generos, 'engine' => $lista_motores] as $key => $lista):
	$key_title_text = Language($key == 'os' ? 'operating-systems' : ($key == 'genre' ? 'genres' : 'engines')) ?? $key;
	$key_option = "";

	foreach ($lista as $opcion) {
		if($key == "os"){
			$key_option .= pCheckboxBoton(['nameidclass' => $key . "_" . Daamper::$scripts->archivoAceptado($opcion), 'texto' => $opcion]) . ' ';
		} else {
			$key_option .= pCheckboxBoton([
				'name' => $key . "_" . Daamper::$scripts->archivoAceptado($opcion),
				'id' => $key . "_" . Daamper::$scripts->archivoAceptado($opcion),
				'texto' => (Language(["games-tags", $opcion], "global") ?? $opcion)
			]) . ' ';
		}
	}

	$return .= <<<HTML
	<details class="sub_container">
		<summary>$key_title_text</summary>
		<section>$key_option</section>
	</details>
	HTML;
endforeach;

// Container thumbnail and options
$image_zone = $fields["link_upload_image"];
$image_zone .= "<details class=\"sub_container\"><summary>" . Language("thumbnail-options") . "</summary><section class=\"flex flex-column gap-4\">";
$image_zone .= $fields["thumbnail_select"] . $fields["thumbnail_url"];
$image_zone .= "</section></details>";

$image_zone .= "<details class=\"sub_container\"><summary>" . Language("poster-options") . "</summary><section class=\"flex flex-column gap-4\">";
$image_zone .= $fields["poster_select"] . $fields["poster_url"];
$image_zone .= "</section></details>";

$image_zone .= "<details class=\"sub_container\"><summary>" . Language("banner-options") . "</summary><section class=\"flex flex-column gap-4\">";
$image_zone .= $fields["banner_select"] . $fields["banner_url"];
$image_zone .= "</section></details>";

$gallery_zone = pInput(['name' => 'galeria_cantidad', 'type' => 'number', 'placeholder' => '3', 'label' => true, 'texto' => Language('quantity'), 'min' => 1, 'max' => 50, 'value' => 4, 'class_label' => 'flex-between', 'required' => true]);
for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']['galeria_cantidad'] ?? 4); $i_local++){
	$gallery_zone .= "<section class=\"sub_container flex flex-column gap-4\">";
	$gallery_zone .= pSelectArchivos(['name' => "galeria_{$i_local}", 'texto' => Language('image'), 'title' => Language('image'), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif', "style" => ""]);
	$gallery_zone .= pInput(['name' => "galeria_{$i_local}_url", 'type' => 'url', 'placeholder' => Language('image').' URL ('.(Language('optional')).')', 'label' => false, 'texto' => Language('image').' URL']);
	$gallery_zone .= "</section>";
}

$return .= <<<HTML
<details class="sub_container">
	<summary>$images_text</summary>
	<section>
		$image_zone
		<details class="sub_container">
			<summary>$gallery_text</summary>
			<section class="flex flex-column gap-4">
				$gallery_zone
			</section>
		</details>
	</section>
</details>
HTML;

$extras_zone = pInput(['name' => 'idiomas', 'label' => true, 'texto' => Language('languages'), 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column', 'required' => true]) .
	pInput(['name' => 'subtitulos', 'label' => true, 'texto' => Language('subtitles'), 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column',]) .
	pInput(['name' => 'desarrollador', 'label' => true, 'texto' => Language('developer'), 'placeholder' => Language('developer'), 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) .
	"<div class=\"flex gap-8\">" .
	pSelect([
		'name' => 'estado',
		'label' => true,
		'texto' => Language('state'),
		'value' => 'development',
		'option' => [
			'development' => Language('development'),
			'completed' => Language('completed'),
			'suspended' => Language('suspended')
		]
	]) .
	pInput(['name' => 'lanzado', 'type' => 'date', 'placeholder' => Language('released'), 'label' => true, 'texto' => Language('released'), 'required' => true]) .
	pInput(['name' => 'terminado', 'type' => 'date', 'placeholder' => Language('completed'), 'label' => true, 'texto' => Language('completed')]) .
	pInput(['name' => 'version', 'class' => 'campo form-campo-mediano', 'placeholder' => '0.1.0', 'label' => true, 'texto' => Language('version')]) .
	pSelect(['name' => "version_estado", 'label' => false, 'texto' => Language('state'), 'option' => $lista_estados]) .
	"</div>";

$return .= <<<HTML
<details class="sub_container">
	<summary>$extras_text</summary>
	<section class="flex flex-column gap-4">
		$extras_zone
	</section>
</details>
HTML;

foreach ($lista_os_requisitos as $os) {
	$os_name = Daamper::$scripts->archivoAceptado($os);
	if (isset($_SESSION['tmpForm']['os_' . $os_name]) && !empty($_SESSION['tmpForm']['os_' . $os_name])) {
		$mostrar_requisitos = true;
		break;
	}
}

if (isset($mostrar_requisitos)):
	foreach (['minimo', "recomendado"] as $value):
		$value_title = $value == "minimo" ? $minimum_requirements_text : $recommended_requirements_text;
		$os_zone_requeriments = "";
		foreach ($lista_os_requisitos as $os):
			$os_name = Daamper::$scripts->archivoAceptado($os);
			if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])):
				$os_zone_requeriments .= "<details class=\"sub_container\">";
					$os_zone_requeriments .= "<summary>$os</summary>";
					$os_zone_requeriments .= "<section>";
					$os_zone_requeriments .= pInput(['name' => "requisito_{$value}_os_{$os_name}_version", 'label' => true, 'texto' => Language('versions'), 'placeholder' => $os_name == 'android' ? '4, 5, 6, 7, 8, 9, 10, 11...' : ('XP/7/9/10/11'), 'class_label' => 'flex-column']) .
						pInput(['name' => "requisito_{$value}_os_{$os_name}_procesador", 'label' => true, 'texto' => Language('proccesor'), 'placeholder' => $os_name == 'android' ? 'Hisilicon Kirin 710' : 'Intel Pentium 4 3.0GHz', 'class_label' => 'flex-column']) .
						pInput(['name' => "requisito_{$value}_os_{$os_name}_targeta_grafica", 'label' => true, 'texto' => Language('graphics-card').' <small>('.(Language('optional')).')</small>', 'placeholder' => 'Nvidia Geforce', 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) .
						pInput(['name' => "requisito_{$value}_os_{$os_name}_ram", 'label' => true, 'texto' => Language('ram'), 'type' => 'number', 'min' => 0, 'max' => 1000, 'placeholder' => '500']) .
						pSelect(['name' => "requisito_{$value}_os_{$os_name}_ram_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) .
						pInput(['name' => "requisito_{$value}_os_{$os_name}_espacio", 'label' => true, 'texto' => Language('storage'), 'min' => 0, 'max' => 1000, 'placeholder' => '500', 'class' => 'campo form-campo-pequeno']) .
						pSelect(['name' => "requisito_{$value}_os_{$os_name}_espacio_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) .
					$os_zone_requeriments .= "</section>";
				$os_zone_requeriments .= "</details>";
			endif;
		endforeach;

		$return .= <<<HTML
		<details class="sub_container">
			<summary>$value_title</summary>
			<section>$os_zone_requeriments</section>
		</details>
		HTML;
	endforeach;
endif;

foreach ($lista_os as $os):
	$os_name = Daamper::$scripts->archivoAceptado($os);
	if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])):
	$download_zone .= "<details class=\"sub_container\">".
		"<summary>$os</summary>".
		"<section class=\"flex-column\">".
			pInput(['name' => "descarga_cantidad_os_{$os_name}", 'type' => 'number', 'label' => true, 'texto' => Language('quantity'), 'placeholder' => 0, 'class' => 'campo form-campo-pequeno', 'class_label' => 'flex-between']);
			for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']["descarga_cantidad_os_{$os_name}"] ?? 1); $i_local++):
				$download_zone .= "<section class=\"flex flex-between gap-4\">".
					"<section class=\"flex gap-4\">".
						pInput(['name' => "descarga_version_{$i_local}_{$os_name}", 'placeholder' => '0.1.0', 'label' => false, 'texto' => Language('version'), 'class' => 'form-campo-pequeno', 'title' => Language(['creator', 'other', 'juego', 'default-used-main'], 'dashboard')]) .
						pInput(['name' => "descarga_peso_{$i_local}_{$os_name}", 'label' => false, 'title' => Language('size'), 'texto' => Language('size'), 'class' => 'form-campo-pequeno', 'placeholder' => '500']) .
						pSelect(['name' => "descarga_peso_{$i_local}_{$os_name}_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) .
					"</section>".
					"<section class=\"flex gap-4\">".
						pSelect(['name' => "descarga_servidor_{$i_local}_{$os_name}", 'label' => false, 'texto' => Language('server'), 'option' => Daamper::$data->Read('creator/default')['server']['downloads'] ?? []]) .
						pInput(['name' => "descarga_enlace_directo_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => Language('link'), 'label' => false, 'texto' => Language('link')]) .
						pInput(['name' => "descarga_enlace_acortado_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => Language('shortened-link'), 'label' => false, 'texto' => Language('shortened-link')]) .
					"</section>".
				"</section>";
			endfor;
		$download_zone .= "</section>".
	"</details>";
	endif;
endforeach;

$return .= <<<HTML
<details class="sub_container">
	<summary>$downloads_text</summary>
	<section>$download_zone</section>
</details>
HTML;

$return .= pSelect([
	'name' => 'ruta',
	'label' => false,
	'style' => 'width: 100%;',
	'texto' => Language('route'),
	'value' => 'juego',
	'option' => [
		'juego/' => 'juego/',
		'game/' => 'game/'
	]
]);

$return .= $fields["file"];