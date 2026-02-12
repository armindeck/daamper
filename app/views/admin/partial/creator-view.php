<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  creator-view.php                                                      */
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

$fields = [
    "title" => pInput(['name' => 'titulo', 'placeholder' => Language('title'), 'title' => Language('title'), 'required' => true]),
    "description" => pInput(['name' => 'descripcion', 'placeholder' => Language("description"), 'title' => Language("description"), 'label' => false, 'texto' => (Language(['creator', 'description'], 'dashboard')), 'required' => true]),
    "meta_description" => pInput(['name' => 'meta_descripcion', 'placeholder' => Language("meta-description"), 'title' => Language("meta-description"), 'required' => true]),
    "catalog" => pInput(['name' => 'catalogo', 'placeholder' => Language("catalog"), 'title' => Language("catalog"), 'required' => true]),
    "meta_tags" => pInput(['name' => 'meta_etiquetas', 'placeholder' => Language("meta-tags"), "title" => Language("meta-tags"), 'required' => true]),
    "fragment" => pTextarea(['name' => 'fragmento', 'placeholder' => Language('fragment'), 'title' => Language('fragment'), 'style' => 'min-height: 50px']),
    "content" => pTextarea(['name' => 'contenido', 'placeholder' => Language('content'), 'title' => Language('content'), 'style' => 'min-height: 250px']),

    "link_upload_image" => pEnlace(['class' => 'boton-2 flex flex-between', 'texto' => Language('upload-image'), 'icono' => 'fas fa-external-link-alt', 'target' => '_blank', 'href' => '?ap=upload-image']),
    "thumbnail_select" => pSelectArchivos(['name' => 'miniatura', "style" => "", 'texto' => Language('thumbnail'), 'title' => Language('thumbnail'), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']),
    "thumbnail_url" => pInput(['name' => 'miniatura_url', 'type' => 'url', 'placeholder' => Language('thumbnail') . ' URL ('.(Language('optional')).')', 'title' => Language('thumbnail') . ' URL ('.(Language('optional')).')']),
    "poster_select" => pSelectArchivos(['name' => 'poster', "style" => "", 'texto' => Language('poster'), 'title' => Language('poster'), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']),
    "poster_url" => pInput(['name' => 'poster_url', 'type' => 'url', 'placeholder' => Language('poster') . ' URL ('.(Language('optional')).')', 'title' => Language('poster') . ' URL ('.(Language('optional')).')']),
    "banner_select" => pSelectArchivos(['name' => 'banner', "style" => "", 'texto' => Language('banner'), 'title' => Language('banner'), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']),
    "banner_url" => pInput(['name' => 'banner_url', 'type' => 'url', 'placeholder' => Language('banner') . ' URL ('.(Language('optional')).')', 'title' => Language('banner') . ' URL ('.(Language('optional')).')']),
    "ads_checkbox" => pCheckboxBoton(['nameidclass' => 'anuncio', 'texto' => (Language('announcement')), 'icono' => 'fas fa-newspaper', 'checked' => true]),
    "private_checbox" => pCheckboxBoton(['nameidclass' => 'privado', 'texto' => Language("private"), 'icono' => 'fas fa-eye-slash']),
    "comment_checkbox" => pCheckboxBoton(['nameidclass' => 'comentar', 'texto' => Language('comment'), 'icono' => 'fas fa-comment-alt', 'checked' => true]),
    "comments_checkbox" => pCheckboxBoton(['nameidclass' => 'comentarios', 'texto' => Language('comments'), 'icono' => 'fas fa-comments', 'checked' => true]),
    "folder" => pInput(['name' => 'ruta', 'placeholder' => strtolower(Language('route')).'/', 'label' => false, 'texto' => (Language('route')), 'title' => (Language('post-route')), 'minlength' => 1]),
    "file" => pInput(['name' => 'archivo', 'placeholder' => strtolower(Language('file')), 'label' => false, 'texto' => (Language('file')), 'title' => (Language('file')), 'minlength' => 1, 'required' => true]),
];

// System to show options to manage the post in the index
$fields["show_in_index_checkbox"] = !file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Creator['get_file'])) ? pCheckboxBoton(['nameidclass' => 'mostrar_en_index', 'texto' => Language('show-in-the-list'), 'icono' => 'fas fa-list', 'checked' => true]) : "";
$fields["show_it_as_new_checkbox"] = $Creator["get_file"] && $Creator["submit_get_type_confirm"] && file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Creator['get_file'])) ?
    pCheckboxBoton(['nameidclass' => 'volver_a_mostrarlo_como_nuevo', 'texto' => Language('show-it-as-new'), 'icono' => 'fas fa-history', 'checked' => false]) : "";
$fields["remove_from_index_checkbox"] = $Creator["get_file"] && $Creator["submit_get_type_confirm"] && file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Creator['get_file'])) ?
    pCheckboxBoton(['nameidclass' => 'quitarlo_del_index', 'texto' => Language('remove-it-from-the-list'), 'icono' => 'fas fa-times-circle', 'checked' => false]) : "";
$fields["creator"] = pInput(['type' => 'hidden', 'name' => 'creador', 'value' => $Creator['get_creator'], 'des_session' => true]);
$fields["pubo"] = pInput(['type' => 'hidden', 'name' => 'pubo', 'value' => $Creator['get_tipo'], 'des_session' => true]);
$fields["db_archivo"] = pInput(['type' => 'hidden', 'name' => 'db_archivo', 'value' => $Creator['get_file'], 'des_session' => true]);

ob_start();
require RAIZ . 'app/views/components/commands-view.php';
$commands_view = "<div class=\"sub_container\">" . ob_get_clean() . "</div>";

$return;

require RAIZ . $Creator["creator_route_file"];

$return .= $Creator["get_file"] && $Creator["submit_get_type_confirm"] && file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Creator['get_file'])) ? 
    '<hr><section class="flex flex-between gap-4">' .
    $fields["show_it_as_new_checkbox"] .
    $fields["remove_from_index_checkbox"] .
    '</section>' : "";

$inputs = $fields["creator"] . $fields["pubo"] . $fields["db_archivo"];
$refresh_text = Language('refresh');
$show_text = Language('show');

$return .= <<<HTML
<hr>
<section class="flex flex-between gap-4">
    $inputs
    <button type="submit" name="refrescar" value="true" class="boton-2"><i class="fas fa-sync-alt"></i> $refresh_text</button>
    <button type="submit" name="mostrar" value="true" class="boton"><i class="fas fa-eye"></i> $show_text</button>
</section>
<hr>
HTML;

$return .= Daamper::$scripts->xv("creator");

return $return;