<?php $Apartado='tema'; ?>
<section class="panel">
	<form action="panel.php?ap=tema" method="get" style="margin-bottom: 0;">
		<strong><?= Language(['tema', 'title'], 'dashboard') ?></strong><hr>
		<details>
			<summary><?= Language(['tema', 'created-themes'], 'dashboard') ?></summary>
			<section class="flex-column">
				<?php $Files = glob(__DIR__ . '/temas/*');
				foreach ($Files as $key => $value) {
					echo '<a href="?ap=tema&tema='.basename($value).'">'.basename($value).'</a>';
				} ?>
			</section>
		</details>
	</form>
	<?php require __DIR__ . '/sub-url.php'; ?>
	<?php $cantidad = isset($Web['tema']['styles']['cantidad']) ? $Web['tema']['styles']['cantidad'] : 1; ?>
</section>
<form method="post" action="procesa/procesa.panel.php" class="panel">
	<section class="form flex-between">
	<?= pInput(['type'=>'text','label'=>true,'texto'=>(Language('name')),'name'=>'nombre_tema','placeholder'=>'Light Space','required'=>true,'value'=>$Web['tema']['styles']['nombre_tema'] ?? '']) ?>
	<?= pInput(['type'=>'text','label'=>true,'texto'=>(Language('file')),'name'=>'archivo','placeholder'=>'tm-tema.php','required'=>true,'value'=>$Web['tema']['styles']['archivo'] ?? '']) ?>
	<?= pInput(['type'=>'number','label'=>true,'texto'=>(Language('quantity')),'name'=>'cantidad','class'=>'form-campo-pequeno','min'=>1,'value'=>$cantidad,'placeholder'=>'Cantidad','required'=>true]) ?>
	</section>
	
	<style type="text/css">.div-lados-label div > label { display: flex; flex-wrap: wrap; flex-direction: row; align-items: center; justify-content: space-between; gap: 4px; }</style>
	<?php
	for ($i = 0; $i < $cantidad; $i++){ ?>
		<section class="form" style="margin-top: 0; margin-bottom: 0;">
			<details>
				<summary><?= isset($Web['tema']['styles'][$i]['titulo']) && !empty($Web['tema']['styles'][$i]['titulo'])  ? $Web['tema']['styles'][$i]['titulo'] : Language('title') ?></summary>
				<section class="div-lados-label flex-column">
			<?=
			pInput(['name'=>'titulo_'.$i,'placeholder'=>(Language('title')),'style'=>'background-color: transparent; border: none; font-weight: bold;','value'=>$Web['tema']['styles'][$i]['titulo'] ?? '']).
			pInput(['name'=>'class_'.$i,'placeholder'=>'Class','texto'=>'Class','label'=>false,'value'=>$Web['tema']['styles'][$i]['class'] ?? '']).' '
			.'<div>'.
				pInput(['type'=>'hidden','min'=>0,'max'=>$cantidad-1,'required'=>true,'name'=>'id_hidden_'.$i,'style'=>'background-color:transparent; border: none; color: var(--text-campo);','placeholder'=>'Identificador','texto'=>'Id hidden','label'=>false,'value'=>isset($Web['tema']['styles'][$i]['id_hidden']) ? $Web['tema']['styles'][$i]['id_hidden'] : $i]).' '.
				pInput(['type'=>'number','min'=>0,'max'=>$cantidad-1,'required'=>true,'name'=>'id_'.$i,'style'=>'background-color:transparent; border: none; color: var(--text-campo);','placeholder'=>'Identificador','texto'=>'Id','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['id']) ? $Web['tema']['styles'][$i]['id'] : $i]).' '
			.'</div><div>'.
				pInput(['name'=>'bg_'.$i,'placeholder'=>'Background color','texto'=>'BG','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['bg']) ? $Web['tema']['styles'][$i]['bg'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'co_'.$i,'placeholder'=>'Color','texto'=>'CO','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['co']) ? $Web['tema']['styles'][$i]['co'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'br_'.$i,'placeholder'=>'Border radius','texto'=>'BR','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['br']) ? $Web['tema']['styles'][$i]['br'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'pd_'.$i,'placeholder'=>'Padding','texto'=>'PD','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['pd']) ? $Web['tema']['styles'][$i]['pd'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'mr_'.$i,'placeholder'=>'Margin','texto'=>'MR','label'=>true,'value'=>isset($Web['tema']['styles'][$i]['mr']) ? $Web['tema']['styles'][$i]['mr'] : '']).
			'</div>';
			echo pTextarea(['name'=>'otros_'.$i,'placeholder'=>(Language(['tema', 'custom-styles'], 'dashboard')),'texto'=>Language('styles'),'label'=>true,'style' => 'min-height: 150px;','value'=>isset($Web['tema']['styles'][$i]['otros']) ? $Web['tema']['styles'][$i]['otros'] : '']);
		echo '</section></details></section>';
	}
	?>
	<section class="form">
		<?= pInput(['type'=>'submit','class'=>'boton','name'=>"procesa_{$Apartado}",'value'=>Language('update'),'des_session'=>true]) ?>
		<hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</section>
</form>