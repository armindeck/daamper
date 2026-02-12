<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  anime_mirando-view.php                                                */
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

$lista_servidores['stream'] = Daamper::$data->Read('creator/default')['server']['streams'] ?? [];
$lista_servidores['descarga'] = Daamper::$data->Read('creator/default')['server']['downloads'] ?? [];

$anime_mirando['cantidad_servidor_stream'] = $_SESSION['tmpForm']['cantidad_servidor_stream'] ?? 1;
$anime_mirando['cantidad_servidor_descarga'] = $_SESSION['tmpForm']['cantidad_servidor_descarga'] ?? 1;

$return .= pSelectArchivos(['style' => 'width: 100%;', 'name'=>'referencia','referencia' => ['anime','hentai'],'texto'=>Language('reference'),'title'=>Language('reference'),'ruta'=>$Web['directorio'].'database/post/','tipo_archivos'=>'json','value-devuelve'=>'basename']);
$return .= pInput(['name'=>'stream_default','type'=>'url','placeholder'=>Language('stream-default'),'texto'=> Language('stream-default'),'required'=>true]);
$return .= "<hr><section class=\"flex flex-between gap-4\">";
$return .= pInput(['name'=>'episodio','type'=>'number','min'=>0,'value'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('episode'),'required'=>true]);
$return .= pInput(['name'=>'cantidad_servidor_stream','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('stream'),'value'=>$anime_mirando['cantidad_servidor_stream'],'required'=>true]);
$return .= pInput(['name'=>'cantidad_servidor_descarga','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('download'),'value'=>$anime_mirando['cantidad_servidor_descarga'],'required'=>true]);
$return .= "</section><hr>";

foreach (['stream', 'descarga'] as $key => $value) {
	$summary_title = $value == 'descarga' ? Language('download') : Language('stream');
	$content_details = "";
	for($i_local = 1; $i_local <= $anime_mirando['cantidad_servidor_' . $value]; $i_local++){
		$content_details .= pSelect(['name'=> 'servidor_'.$value.'_'.$i_local, 'texto'=> Language('server'), 'option'=> $lista_servidores[$value]]);
		$content_details .= pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace','type'=>'url','placeholder' => Language('link')]);
		$content_details .= $value == 'descarga' ?
			pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace_acortado','type'=>'url','placeholder'=>Language('shortened-link')]) : '';
		$content_details .= $i_local < $anime_mirando['cantidad_servidor_' . $value] ? "<hr>" : "";
	}
	$return .= <<<HTML
		<details class="sub_container">
			<summary>$summary_title</summary>
			<section class="flex-column">$content_details</section>
		</details>
	HTML;
}

// Container thumbnail and options
$return .= "<div class=\"sub_container\">";
$return .= "<details><summary>" . Language("thumbnail-options") . "</summary><section class=\"flex flex-column gap-4\">";
$return .= $fields["link_upload_image"] . $fields["thumbnail_select"] . $fields["thumbnail_url"];
$return .= "</section></details></div>";

$return .= "<hr>" . $fields["private_checbox"];
