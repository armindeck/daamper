<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  anime_entrada-view.php                                                */
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

require RAIZ . "app/actions/admin/content/global/creators/script/anime_entrada.php";

$return .= $fields["title"] . "<small>" . Language("markdown-is-supported") . "</small>";

$return .= pTextarea(['name'=>'sinopsis','placeholder'=>Language(['synopsis']),'label'=>false,'texto'=>Language(['synopsis']),'style'=>'min-height:100px','required'=>true]);

$categories_list = "";
foreach ($lista_categorias as $key => $value) {
	$categories_list .= pCheckboxBoton(['name' => $key, 'id'=> "input-check-".Daamper::$scripts->archivoAceptado($value), 'texto'=>$value]);
}

$text_categories = Language('categories');
$text_images = Language('images');
$text_extras = Language('extras');

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


$extras_zone = "<hgroup class=\"flex gap-8\">";
$extras_zone .= pSelect(['name'=>'idioma','label'=>true,'texto'=>Language('language'),'value'=>'japanese','option'=> [
	'japanese' => Language('japanese'),
	'spanish' => Language('spanish'),
	'english' => Language('english'),
	'chinese' => Language('chinese'),
	'castilian' => Language('castilian')
]]);
$extras_zone .= pSelect(['name'=>'subtitulo','label'=>true,'texto'=>Language('subtitle'),'value'=>'spanish','option'=> [
	'japanese' => Language('japanese'),
	'spanish' => Language('spanish'),
	'english' => Language('english'),
	'chinese' => Language('chinese'),
	'castilian' => Language('castilian'),
	''
]]);
$extras_zone .= pSelect(['name'=>'estado','label'=>true,'texto'=>Language('state'),'value'=>'airing','option'=> [
	'airing' => Language('airing'),
	'finalized' => Language('finalized'),
	'suspended' => Language('suspended')
]]);
$extras_zone .= "</hgroup>";

$extras_zone .= "<hgroup class=\"flex gap-8\">";
$extras_zone .= pInput(['name'=>'episodios','type'=>'number','min'=>0,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('episodes'),'required'=>true]);
$extras_zone .= pSelect(['name'=>'episodios_cada','label'=>true,'texto'=>Language('every'),'option'=> [
	'monday' => Language('monday'),
	'tuesday' => Language('tuesday'),
	'wednesday' => Language('wednesday'),
	'thursday' => Language('thursday'),
	'friday' => Language('friday'),
	'saturday' => Language('saturday'),
	'sunday' => Language('sunday'),
	'undefined' => Language('undefined')
]]);
$extras_zone .= "</hgroup>";

$extras_zone .= "<hgroup class=\"flex gap-8\">";
$extras_zone .= pInput(['name'=>'estreno','type'=>'date','placeholder'=>Language('premiere'),'label'=>true,'texto'=>Language('premiere'),'required'=>true]);
$extras_zone .= pInput(['name'=>'finalizo','type'=>'date','placeholder'=>Language('ended'),'label'=>true,'texto'=>Language('ended')]);
$extras_zone .= "</hgroup>";

$extras_zone .= "<hgroup class=\"flex flex-column gap-4\">";
$extras_zone .= pSelect(['name'=>'catalogo','label'=>true,'texto'=>Language('catalog'),'value'=>'anime','option'=> [
	'anime' => Language('anime'),
	'hentai' => Language('hentai'),
	'movie' => Language('movie'),
	'ova' => Language('ova')
]]);
$extras_zone .= "</hgroup>";


$return .= <<<HTML
<details class="sub_container">
	<summary>$text_categories</summary>
	<section>$categories_list</section>
</details>
<details class="sub_container">
	<summary>$text_images</summary>
	<section class="flex flex-column gap-4">$image_zone</section>
</details>
<details class="sub_container">
	<summary>$text_extras</summary>
	<section class="flex flex-column gap-8">$extras_zone</section>
</details>
HTML;

$return .= pSelect(['name'=>'ruta','label'=>false,'style'=>'width: 100%;', 'texto'=>Language('route'),'value'=>'anime','option'=>[
	'anime/' => 'anime/', 'hentai/' => 'hentai/']
]);

$return .= $fields["file"];
