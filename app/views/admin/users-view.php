<?php /* 07/01/2025 */  $Apartado = 'users'; ?>
<section class="panel">
	<div class="form" style="margin-bottom: 0;">
		<strong><?= Language('users') ?></strong>
	</div>
	<form method="post" action="process/actions.php" style="margin-top: 0;">
	<?php foreach (Daamper::$data->UserAll() as $key => $value) { ?>
		<details <?= $key < 3 ? 'open' : '' ?>><summary><strong><?= $value['nombre'] ?></strong></summary>
			<ul class="flex-column">
			<?php foreach ($value as $key_value => $value_2) { if(!in_array($key_value, ['id', 'contrasena', 'pin'])){?>
				<li class="flex-between">
					<span><?= str_replace("_", " ", ucfirst($key_value)) ?>:</span>
					<span>
						<?php if (!in_array($key_value, ['rol', 'estado'])){ ?>
							<p class="campo t-14"><?= !is_array($value_2) ? $value_2 : "Array" ?></p>
						<?php } else { ?>
							<select name="<?= $key_value .'-us-'. $value['id'] ?>">
								<?php $lista = $key_value == 'rol' ?
									['Usuario', 'Editor', 'Administrador', 'CEO Founder'] :
									['Publico', 'Suspendido', 'Eliminado']; ?>
								<?php foreach ($lista as $value_3) {
										echo "<option " . (strtolower($value_2) == strtolower($value_3) ? 'selected' : '') .">$value_3</option>";
								} ?>
							</select>
						<?php } ?>
					</span>
				</li>
			<?php } } ?>
			</ul>
		</details><hr>
	<?php } ?>
	<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]) ?><hr>
	<?= Daamper::$scripts->xv($Apartado) ?>
	</form>
</section>