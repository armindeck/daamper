<?php $Apartado='theme'; ?>
<section class="panel">
	<form action="admin.php?ap=theme" method="get" style="margin-bottom: 0;">
		<strong><?= Language(['theme', 'title'], 'dashboard') ?></strong><hr>
		<details>
			<summary><?= Language(['theme', 'created-themes'], 'dashboard') ?></summary>
			<section class="flex-column">
				<?php $Files = glob($Web["directorio"] . 'database/theme/*');
				foreach ($Files as $key => $value) {
					if (basename($value) != "theme.json"){
						echo '<a href="?ap=theme&tema='.basename($value).'">'.str_replace(".json", "", basename($value)).'</a>';
					}
				} ?>
			</section>
		</details>
	</form>
	<?php require $Web["directorio"] . "app/actions/admin/content/global/src/theme.php"; ?>
	<?php $cantidad = isset($Web['theme']['styles']['cantidad']) ? $Web['theme']['styles']['cantidad'] : 1; ?>
</section>
<form method="post" action="process/actions.php" class="panel">
	<section class="form flex-between">
	<?= pInput(['type'=>'text','label'=>true,'texto'=>(Language('name')),'name'=>'nombre_tema','placeholder'=>'Pink Aero','required'=>true,'value'=>$Web['theme']['styles']['nombre_tema'] ?? '']) ?>
	<?= pInput(['type'=>'text','label'=>true,'texto'=>(Language('file')),'name'=>'archivo','placeholder'=>'tm-pink-aero.json','required'=>true,'value'=>$Web['theme']['styles']['archivo'] ?? '']) ?>
	<?= pInput(['type'=>'number','label'=>true,'texto'=>(Language('quantity')),'name'=>'cantidad','class'=>'form-campo-pequeno','min'=>1,'value'=>$cantidad,'placeholder'=>'Cantidad','required'=>true]) ?>
	</section>
	
	<style type="text/css">.div-lados-label div > label { display: flex; flex-wrap: wrap; flex-direction: row; align-items: center; justify-content: space-between; gap: 4px; }</style>
	<?php
	for ($i = 0; $i < $cantidad; $i++){ ?>
		<section class="form" style="margin-top: 0; margin-bottom: 0;">
			<details>
				<summary><?= isset($Web['theme']['styles'][$i]['titulo']) && !empty($Web['theme']['styles'][$i]['titulo'])  ? $Web['theme']['styles'][$i]['titulo'] : Language('title') ?></summary>
				<section class="div-lados-label flex-column">
			<?=
			pInput(['name'=>'titulo_'.$i,'placeholder'=>(Language('title')),'style'=>'background-color: transparent; border: none; font-weight: bold;','value'=>$Web['theme']['styles'][$i]['titulo'] ?? '']).
			pInput(['name'=>'class_'.$i,'placeholder'=>'Class','texto'=>'Class','label'=>false,'value'=>$Web['theme']['styles'][$i]['class'] ?? '']).' '
			.'<div>'.
				pInput(['type'=>'hidden','min'=>0,'max'=>$cantidad-1,'required'=>true,'name'=>'id_hidden_'.$i,'style'=>'background-color:transparent; border: none; color: var(--text-campo);','placeholder'=>'Identificador','texto'=>'Id hidden','label'=>false,'value'=>isset($Web['theme']['styles'][$i]['id_hidden']) ? $Web['theme']['styles'][$i]['id_hidden'] : $i]).' '.
				pInput(['type'=>'number','min'=>0,'max'=>$cantidad-1,'required'=>true,'name'=>'id_'.$i,'style'=>'background-color:transparent; border: none; color: var(--text-campo);','placeholder'=>'Identificador','texto'=>'Id','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['id']) ? $Web['theme']['styles'][$i]['id'] : $i]).' '
			.'</div><div>'.
				pInput(['name'=>'bg_'.$i,'placeholder'=>'Background color','texto'=>'BG','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['bg']) ? $Web['theme']['styles'][$i]['bg'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'co_'.$i,'placeholder'=>'Color','texto'=>'CO','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['co']) ? $Web['theme']['styles'][$i]['co'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'br_'.$i,'placeholder'=>'Border radius','texto'=>'BR','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['br']) ? $Web['theme']['styles'][$i]['br'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'pd_'.$i,'placeholder'=>'Padding','texto'=>'PD','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['pd']) ? $Web['theme']['styles'][$i]['pd'] : '']).' '
			.'</div><div>'.
				pInput(['name'=>'mr_'.$i,'placeholder'=>'Margin','texto'=>'MR','label'=>true,'value'=>isset($Web['theme']['styles'][$i]['mr']) ? $Web['theme']['styles'][$i]['mr'] : '']).
			'</div>';
			echo pTextarea(['name'=>'otros_'.$i,'placeholder'=>(Language(['theme', 'custom-styles'], 'dashboard')),'texto'=>Language('styles'),'label'=>true,'style' => 'min-height: 150px;','value'=>isset($Web['theme']['styles'][$i]['otros']) ? $Web['theme']['styles'][$i]['otros'] : '']);
		echo '</section></details></section>';
	}
	?>
	<section class="form">
		<?= pInput(['type'=>'submit','class'=>'boton','name'=>"procesa_{$Apartado}",'value'=>Language('update'),'des_session'=>true]) ?>
		<hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</section>
</form>