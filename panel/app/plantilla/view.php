<?php $Apartado='plantilla'; ?>
<form method="post" action="procesa/procesa.plantilla.php" style="max-width: 99%;">
	<section class="panel">
		<section class="form" style="margin-bottom: 0;">
			<section class="flex-between">
				<strong><?= LANGUAJE['global']['template'][CONFIG['languaje']] ?></strong>
				<section>
					<?=
					pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['icono' => 'fas fa-sitemap', 'name' => 'cargar_scripts','texto-2'=>LANGUAJE['global']['scripts'][CONFIG['languaje']],'title'=>LANGUAJE['global']['enable-or-disable-scripts'][CONFIG['languaje']]]).
					pEnlace(['texto'=>LANGUAJE['global']['show'][CONFIG['languaje']],'icono'=>'fas fa-external-link-alt','class'=>'boton-2 boton-mini','target'=>'_blank','href'=>'?ap=directorio&dir=../app/scripts/plantilla/']);
					?>
				</section>
			</section>
			<details>
				<summary><?= LANGUAJE['global']['templates'][CONFIG['languaje']] ?></summary>
				<section class="flex-column t-14">
					<?php $ruta_plantillas = glob(__DIR__.'/plantillas/*.php');
						foreach ($ruta_plantillas as $plantilla) {
							if (substr(basename($plantilla), 0, 4) != 'scr-') {
								echo '<a href="?ap=plantilla&plantilla='.basename($plantilla).'&accion=mostrar">'.basename($plantilla).'</a>';
							}
						}
					?>
				</section>
			</details>
			<details>
				<summary><?= LANGUAJE['global']['options'][CONFIG['languaje']] ?></summary>
				<section class="flex-column">
					<?= pInput(['placeholder'=>'mi-plantilla.php ('.LANGUAJE['global']['optional'][CONFIG['languaje']].')','title'=>LANGUAJE['global']['file'][CONFIG['languaje']],'name'=>'archivo_plantilla','style'=>'width: 100%;','value'=>(isset($Web[$Apartado]['archivo_plantilla']) ? trim(htmlspecialchars($Web[$Apartado]['archivo_plantilla'])) : '')]); ?>
					<?= pInput(['placeholder'=>'4','class'=>'form-campo-pequeno','title'=>LANGUAJE['global']['quantity'][CONFIG['languaje']],'name'=>'cantidad_contenedores','label'=>true,'class_label'=>'flex-between','texto'=>LANGUAJE['global']['quantity'][CONFIG['languaje']],'min'=> 0, 'max'=> 99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_contenedores']) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_contenedores'])) : 0),'required' => true]); ?>
					<details open>
						<summary><?= LANGUAJE['global']['extras'][CONFIG['languaje']] ?></summary>
						<section class="flex-between">
							<a class="boton-2 boton-mini" href="?ap=plantilla&accion=restaurar"><?= LANGUAJE['global']['restore'][CONFIG['languaje']] ?></a>
						</section>
					</details>
				</section>
			</details>
		</section>
		<?php if (isset($_GET['plantilla']) && !empty($_GET['plantilla']) && file_exists(__DIR__."/plantillas/{$_GET['plantilla']}")): $get_plantilla = true; ?>
		<section class="form" style="margin-bottom: 0; margin-top: 0;">
			<details open>
				<summary><?= LANGUAJE['global']['template'][CONFIG['languaje']] ?>: <?= SCRIPTS->normalizar($_GET['plantilla']) ?></summary>
				<section class="flex-between">
					<a href="#procesa_actualizar" class="boton-2 boton-mini"><?= LANGUAJE['global']['use'][CONFIG['languaje']] ?></a>
					<a class="boton boton-mini" href="?ap=plantilla&plantilla=<?= SCRIPTS->normalizar($_GET['plantilla']) ?>&accion=eliminar"><i class="fas fa-trash"></i> <?= LANGUAJE['global']['delete'][CONFIG['languaje']] ?></a>
				</section>
			</details>
		</section>
		<?php endif; ?>
		<?php if(isset($Web[$Apartado]['cargar_scripts']) && !empty($Web[$Apartado]['cargar_scripts']) &&
			!file_exists(__DIR__ . '/procesa_scripts.php')): ?>
			<section class="form" style="background-color: red; color: white;">
				<p>
					<?= LANGUAJE['global']['file-no-exists'][CONFIG['languaje']][0] ?>
					<strong>procesa_scripts.php</strong>
					<?= LANGUAJE['global']['file-no-exists'][CONFIG['languaje']][1] ?>
				</p>
			</section>
		<?php endif; ?>
	</section>
	<?php if(isset($Web[$Apartado]['cantidad_contenedores']) && !empty($Web[$Apartado]['cantidad_contenedores'])):
		for($i = 1; $i <= $Web[$Apartado]['cantidad_contenedores']; $i++): $Web[$Apartado]['contenedor'] = $i; ?>
		<section class="panel" style="margin: 0px auto; align-content: center; gap: 4px; padding: 4px; flex-direction: column;">
			<section class="form" style="margin-bottom: 0;">
				<section class="flex-between">
					<strong><?= (isset($Web[$Apartado]['nombre_contenedor_'.$i]) && !empty($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : "Sección #$i") ?></strong>
					<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>'mostrar_contenedor_'.$i,'title'=>LANGUAJE['global']['show-or-hide-section'][CONFIG['languaje']]]); ?>
				</section>
				<details>
					<summary><?= LANGUAJE['global']['data'][CONFIG['languaje']] ?></summary>
					<section class="flex-between">
						<?= pSelect(['title'=>LANGUAJE['global']['section-type'][CONFIG['languaje']], 'label' => true,'texto' => LANGUAJE['global']['type'][CONFIG['languaje']], 'option' => [
							'components' => LANGUAJE['global']['components'][CONFIG['languaje']],
							'normal' => LANGUAJE['global']['normal'][CONFIG['languaje']],
							'header' => LANGUAJE['global']['header'][CONFIG['languaje']],
							'header-bar' => LANGUAJE['global']['header-bar'][CONFIG['languaje']],
							'sidebar' => LANGUAJE['global']['sidebar'][CONFIG['languaje']],
							'open-content' => LANGUAJE['global']['open-content'][CONFIG['languaje']],
							'main-header' => LANGUAJE['global']['main-header'][CONFIG['languaje']],
							'main' => LANGUAJE['global']['main'][CONFIG['languaje']],
							'main-footer' => LANGUAJE['global']['main-footer'][CONFIG['languaje']],
							'article' => LANGUAJE['global']['article'][CONFIG['languaje']],
							'close-content' => LANGUAJE['global']['close-content'][CONFIG['languaje']],
							'footer' => LANGUAJE['global']['footer'][CONFIG['languaje']]
							], 'name' => "tipo_contenedor_$i", 'value'=>(isset($Web[$Apartado]['tipo_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['tipo_contenedor_'.$i])) : '')]) ?>
						<?= pInput(['placeholder'=>'1','class'=>'form-campo-pequeno','title'=>LANGUAJE['global']['number-elements-section'][CONFIG['languaje']],'name'=>'cantidad_elementos_contenedor_'.$i,'label'=>true,'texto'=>LANGUAJE['global']['elements'][CONFIG['languaje']],'min'=>0,'max'=>99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])) : 0)]) ?>
						<?= pInput(['placeholder'=>LANGUAJE['global']['name'][CONFIG['languaje']].' ('.LANGUAJE['global']['optional'][CONFIG['languaje']].')','title'=>LANGUAJE['global']['section-name'][CONFIG['languaje']],'name'=>'nombre_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : '')]); ?>
					</section>
					<details>
						<summary><?= LANGUAJE['global']['container'][CONFIG['languaje']] ?></summary>
						<section>
							<?= pTextarea(['title'=>LANGUAJE['global']['open-container'][CONFIG['languaje']],'placeholder'=>htmlspecialchars('<article class="article">'."\n<Return=NombreWeb>"),'name'=>'div_abrir_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_contenedor_'.$i])) : '')]) ?>
							<?= pTextarea(['title'=>LANGUAJE['global']['close-container'][CONFIG['languaje']],'placeholder'=>htmlspecialchars("<View=article>\n</article>"),'name'=>'div_cerrar_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_contenedor_'.$i])) : '')]) ?>
						</section>
					</details>
				</details>
			</section>
			<?php if(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) && !empty($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])): ?>
				<details>
					<summary style="margin-left: 16px;"><?= LANGUAJE['global']['elements'][CONFIG['languaje']] ?></summary>
					<div class="panel">
					<?php for($ii = 1; $ii <= $Web[$Apartado]['cantidad_elementos_contenedor_'.$i]; $ii++): $Web[$Apartado]['elemento'] = $ii; ?>
					<section class="form" style="margin: 0px 12px;">
						<section class="flex-between">
							<strong><?= LANGUAJE['global']['element'][CONFIG['languaje']] ?> #<?= $ii ?></strong>
							<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>"mostrar_elemento_{$ii}_contenedor_{$i}",'title'=>LANGUAJE['global']['show-or-hide-element'][CONFIG['languaje']]]); ?>
						</section>
						<details>
							<summary style="font-size: 14px;"><?= LANGUAJE['global']['expand'][CONFIG['languaje']] ?></summary>
							<section>
							<details>
								<summary><?= LANGUAJE['global']['title'][CONFIG['languaje']] ?></summary>
								<?= pInput(['placeholder'=>LANGUAJE['global']['title'][CONFIG['languaje']],'title'=>LANGUAJE['global']['title'][CONFIG['languaje']],'style' => 'width: 100%;','name'=>'titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
							</details>
							<details>
								<summary><?= LANGUAJE['global']['content'][CONFIG['languaje']] ?></summary>
								<?= pTextarea(['placeholder'=>LANGUAJE['global']['content'][CONFIG['languaje']],'name'=>'contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : ''),'style'=>'min-height:150px;']) ?>
							</details>
							<details>
								<summary><?= LANGUAJE['global']['container'][CONFIG['languaje']] ?></summary>
								<section class="flex-between">
								<?= pInput(['placeholder'=>htmlspecialchars('<div class="">'),'title'=>LANGUAJE['global']['open-element-container'][CONFIG['languaje']],'name'=>'div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								<?= pInput(['placeholder'=>htmlspecialchars('</div>'),'title'=>LANGUAJE['global']['close-element-container'][CONFIG['languaje']],'name'=>'div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['invertir' => true, 'name'=>'ocultar_etiquetas_contenedor_campos_default_elemento_'.$ii.'_contenedor_'.$i,'title'=>LANGUAJE['global']['hide-or-how-the-element-container-tags'][CONFIG['languaje']]]); ?>
								</section>
							</details>
							<details>
								<summary><?= LANGUAJE['global']['styles'][CONFIG['languaje']] ?></summary>
								<?= pTextarea(['placeholder'=>htmlspecialchars(".boton { color: red; background-color: white; }\n.form { padding: 4px; border-radius: 4px; }\n.check:checked { color: white; box-shadow: 0px 0px 1px 1px #2f9; }"),'style'=>'width:100%; min-height:100px;','title'=>'CSS','name'=>'estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
							</details>
							<details>
								<summary><?= LANGUAJE['global']['scripts'][CONFIG['languaje']] ?></summary>
								<details>
									<summary><?= LANGUAJE['global']['commands'][CONFIG['languaje']] ?> <small>~ <?= LANGUAJE['global']['beta'][CONFIG['languaje']] ?></small></summary>
									<?= pTextarea(['placeholder'=>htmlspecialchars("[Return=NombreWeb]\n[Form=Input name=".'""'." placeholder=".'""'." title=".'""'."]\n[Return=InputEnlace name=".'""'."]\n[Return=InputEnlaceSesion name=".'""'."]\n[Return=InputEnlaceNoSesion name=".'""'."]\n[Return=Visitas]\n[View=article]\n[Return=WebVersion]"),'style'=>'width:100%; min-height:100px;','title'=>LANGUAJE['dashboard']['template']['commands-title'][CONFIG['languaje']],'name'=>'comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								</details>
								<?= isset($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) && !empty($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? PlantillaComandos($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i], $i, $ii) : '' ?>
							</details>
						</section>
					</section>
					<?php endfor; ?>
					</div>
				</details>
			<?php endif; ?>
		</section>
		<?php endfor; ?>
	<?php endif; ?>
	<section class="panel">
		<section class="form">
		<?= pInput(['type'=>'submit','class'=>'boton','id'=>'procesa_actualizar','name'=>"procesa_$Apartado",'value'=>isset($get_plantilla) ? LANGUAJE['global']['use'][CONFIG['languaje']] : LANGUAJE['global']['update'][CONFIG['languaje']]]) ?>
		<hr>
		<?= SCRIPTS->xv($Apartado) ?>
		</section>
	</section>
</form>