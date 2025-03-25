<?php $Apartado='plantilla'; ?>
<form method="post" action="procesa/procesa.plantilla.php" style="max-width: 99%;">
	<section class="panel">
		<section class="form" style="margin-bottom: 0;">
			<section class="flex-between">
				<strong><?= Language('template') ?></strong>
				<section>
					<?=
					pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['icono' => 'fas fa-sitemap', 'name' => 'cargar_scripts','texto-2'=>Language('scripts'),'title'=>Language('enable-or-disable-scripts')]).
					pEnlace(['texto'=>Language('show'),'icono'=>'fas fa-external-link-alt','class'=>'boton-2 boton-mini','target'=>'_blank','href'=>'?ap=directorio&dir=../app/scripts/plantilla/']);
					?>
				</section>
			</section>
			<details>
				<summary><?= Language("templates"); ?></summary>
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
				<summary><?= Language('options') ?></summary>
				<section class="flex-column">
					<?= pInput(['placeholder'=>strtolower(Language('template')).'.php ('.Language('optional').')','title'=>Language('file'),'name'=>'archivo_plantilla','style'=>'width: 100%;','value'=>(isset($Web[$Apartado]['archivo_plantilla']) ? trim(htmlspecialchars($Web[$Apartado]['archivo_plantilla'])) : '')]); ?>
					<?= pInput(['placeholder'=>'4','class'=>'form-campo-pequeno','title'=>Language('quantity'),'name'=>'cantidad_contenedores','label'=>true,'class_label'=>'flex-between','texto'=>Language('quantity'),'min'=> 0, 'max'=> 99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_contenedores']) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_contenedores'])) : 0),'required' => true]); ?>
					<details open>
						<summary><?= Language('extras') ?></summary>
						<section class="flex-between">
							<a class="boton-2 boton-mini" href="?ap=plantilla&accion=restaurar"><?= Language('restore') ?></a>
						</section>
					</details>
				</section>
			</details>
		</section>
		<?php if (isset($_GET['plantilla']) && !empty($_GET['plantilla']) && file_exists(__DIR__."/plantillas/{$_GET['plantilla']}")): $get_plantilla = true; ?>
		<section class="form" style="margin-bottom: 0; margin-top: 0;">
			<details open>
				<summary><?= Language('template') ?>: <?= SCRIPTS->normalizar($_GET['plantilla']) ?></summary>
				<section class="flex-between">
					<a href="#procesa_actualizar" class="boton-2 boton-mini"><?= Language('use') ?></a>
					<a class="boton boton-mini" href="?ap=plantilla&plantilla=<?= SCRIPTS->normalizar($_GET['plantilla']) ?>&accion=eliminar"><i class="fas fa-trash"></i> <?= Language('delete') ?></a>
				</section>
			</details>
		</section>
		<?php endif; ?>
		<?php if(isset($Web[$Apartado]['cargar_scripts']) && !empty($Web[$Apartado]['cargar_scripts']) &&
			!file_exists(__DIR__ . '/procesa_scripts.php')): ?>
			<section class="form" style="background-color: red; color: white;">
				<p><?= Language('file-no-exists', 'global', ['value' => '<strong>procesa_scripts.php</strong>']) ?></p>
			</section>
		<?php endif; ?>
	</section>
	<?php if(isset($Web[$Apartado]['cantidad_contenedores']) && !empty($Web[$Apartado]['cantidad_contenedores'])):
		for($i = 1; $i <= $Web[$Apartado]['cantidad_contenedores']; $i++): $Web[$Apartado]['contenedor'] = $i; ?>
		<section class="panel" style="margin: 0px auto; align-content: center; gap: 4px; padding: 4px; flex-direction: column;">
			<section class="form" style="margin-bottom: 0;">
				<section class="flex-between">
					<strong><?= (isset($Web[$Apartado]['nombre_contenedor_'.$i]) && !empty($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : "Sección #$i") ?></strong>
					<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>'mostrar_contenedor_'.$i,'title'=>Language('show-or-hide-section')]); ?>
				</section>
				<details>
					<summary><?= Language('data') ?></summary>
					<section class="flex-between">
						<?= pSelect(['title'=>Language('section-type'), 'label' => true,'texto' => Language('type'), 'option' => [
							'components' => Language('components'),
							'normal' => Language('normal'),
							'header' => Language('header'),
							'header-bar' => Language('header-bar'),
							'sidebar' => Language('sidebar'),
							'open-content' => Language('open-content'),
							'main-header' => Language('main-header'),
							'main' => Language('main'),
							'main-footer' => Language('main-footer'),
							'article' => Language('article'),
							'close-content' => Language('close-content'),
							'footer' => Language('footer')
							], 'name' => "tipo_contenedor_$i", 'value'=>(isset($Web[$Apartado]['tipo_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['tipo_contenedor_'.$i])) : '')]) ?>
						<?= pInput(['placeholder'=>'1','class'=>'form-campo-pequeno','title'=>Language('number-elements-section'),'name'=>'cantidad_elementos_contenedor_'.$i,'label'=>true,'texto'=>Language('elements'),'min'=>0,'max'=>99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])) : 0)]) ?>
						<?= pInput(['placeholder'=>Language('name').' ('.Language('optional').')','title'=>Language('section-name'),'name'=>'nombre_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : '')]); ?>
					</section>
					<details>
						<summary><?= Language('container') ?></summary>
						<section>
							<?= pTextarea(['title'=>Language('open-container'),'placeholder'=>htmlspecialchars('<article class="article">'."\n<Return=NombreWeb>"),'name'=>'div_abrir_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_contenedor_'.$i])) : '')]) ?>
							<?= pTextarea(['title'=>Language('close-container'),'placeholder'=>htmlspecialchars("<View=article>\n</article>"),'name'=>'div_cerrar_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_contenedor_'.$i])) : '')]) ?>
						</section>
					</details>
				</details>
			</section>
			<?php if(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) && !empty($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])): ?>
				<details>
					<summary style="margin-left: 16px;"><?= Language('elements') ?></summary>
					<div class="panel">
					<?php for($ii = 1; $ii <= $Web[$Apartado]['cantidad_elementos_contenedor_'.$i]; $ii++): $Web[$Apartado]['elemento'] = $ii; ?>
					<section class="form" style="margin: 0px 12px;">
						<section class="flex-between">
							<strong><?= Language('element') ?> #<?= $ii ?></strong>
							<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>"mostrar_elemento_{$ii}_contenedor_{$i}",'title'=>Language('show-or-hide-element')]); ?>
						</section>
						<details>
							<summary style="font-size: 14px;"><?= Language('expand') ?></summary>
							<section>
							<details>
								<summary><?= Language('title') ?></summary>
								<?= pInput(['placeholder'=>Language('title'),'title'=>Language('title'),'style' => 'width: 100%;','name'=>'titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
							</details>
							<details>
								<summary><?= Language('content') ?></summary>
								<?= pTextarea(['placeholder'=>Language('content'),'name'=>'contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : ''),'style'=>'min-height:150px;']) ?>
							</details>
							<details>
								<summary><?= Language('container') ?></summary>
								<section class="flex-between">
								<?= pInput(['placeholder'=>htmlspecialchars('<div class="">'),'title'=>Language('open-element-container'),'name'=>'div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								<?= pInput(['placeholder'=>htmlspecialchars('</div>'),'title'=>Language('close-element-container'),'name'=>'div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['invertir' => true, 'name'=>'ocultar_etiquetas_contenedor_campos_default_elemento_'.$ii.'_contenedor_'.$i,'title'=>Language('hide-or-how-the-element-container-tags')]); ?>
								</section>
							</details>
							<details>
								<summary><?= Language('styles') ?></summary>
								<?= pTextarea(['placeholder'=>htmlspecialchars(".boton { color: red; background-color: white; }\n.form { padding: 4px; border-radius: 4px; }\n.check:checked { color: white; box-shadow: 0px 0px 1px 1px #2f9; }"),'style'=>'width:100%; min-height:100px;','title'=>'CSS','name'=>'estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
							</details>
							<details>
								<summary><?= Language('scripts') ?></summary>
								<details>
									<summary><?= Language('commands') ?> <small>~ <?= Language('beta') ?></small></summary>
									<?= pTextarea(['placeholder'=>htmlspecialchars("[Return=NombreWeb]\n[Form=Input name=".'""'." placeholder=".'""'." title=".'""'."]\n[Return=InputEnlace name=".'""'."]\n[Return=InputEnlaceSesion name=".'""'."]\n[Return=InputEnlaceNoSesion name=".'""'."]\n[Return=Visitas]\n[View=article]\n[Return=WebVersion]"),'style'=>'width:100%; min-height:100px;','title'=>Language(['template', 'commands-title'], 'dashboard'),'name'=>'comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
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
		<?= pInput(['type'=>'submit','class'=>'boton','id'=>'procesa_actualizar','name'=>"procesa_$Apartado",'value'=>isset($get_plantilla) ? Language('use') : Language('update')]) ?>
		<hr>
		<?= SCRIPTS->xv($Apartado) ?>
		</section>
	</section>
</form>