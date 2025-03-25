<?php if(!isset($_GET['ap'])): ?>
	<section class="con">
        <strong><?= Language(['dashboard', 'wellcome-dashboard'], 'dashboard') ?></strong><hr>
        <?= Language(['dashboard', 'text'], 'dashboard') ?>
    </section>
<?php endif; ?>
<?php if(isset($_GET['ap'])):
  $httpGET['ap'] = SCRIPTS->normalizar2($_GET['ap']);
  $File = $Web['directorio'] . "panel/app/{$httpGET['ap']}/view.php";
  if(!file_exists($File)): ?>
    <section class="con">
      <strong><?= Language('attention') ?></strong><hr>
      <?= Language(['dashboard', 'attention'], 'dashboard', ['value' => "<strong>".$httpGET['ap']."</strong>"]) ?>
    </section>
  <?php endif; ?>
<?php endif; ?>
<details class="con" <?= !isset($_GET['ap']) ? 'open' : (!file_exists($Web['directorio'] . "panel/app/{$_GET['ap']}/view.php") ? 'open' : '') ?>>
	<summary><?= Language('sections') ?></summary>
	<section class="flex-column botones-2 botones-mini">
		<?php foreach (require __DIR__.'/panel-lista-view.php' as $key => $value) { ?>
			<a href="?ap=<?= $value['apartado'] ?>"><i class="<?= $value['icono'] ?>"></i> <?= $value['texto'] ?></a>
		<?php } ?>
		<a target="_blank" href="<?= INFO['page-url'] ?>"><i class="fas fa-history"></i> <?= Language('update') ?></a>
		<a href="?ap=info"><i class="fas fa-tractor"></i> <?= Language('information') ?></a>
	</section>
</details>
<?php if(isset($_GET['ap']) && file_exists($File)){ require_once $File; } ?>