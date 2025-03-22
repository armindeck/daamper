<?php if(!isset($_GET['ap'])): ?>
	<section class="con">
        <strong><?= LANGUAJE['dashboard']['dashboard']['wellcome-dashboard'][CONFIG['languaje']] ?></strong><hr>
        <?= LANGUAJE['dashboard']['dashboard']['text'][CONFIG['languaje']] ?>
    </section>
<?php endif; ?>
<?php if(isset($_GET['ap'])):
  $httpGET['ap'] = SCRIPTS->normalizar2($_GET['ap']);
  $File = $Web['directorio'] . "panel/app/{$httpGET['ap']}/view.php";
  if(!file_exists($File)): ?>
    <section class="con">
      <strong><?= LANGUAJE['global']['attention'][CONFIG['languaje']] ?></strong><hr>
      <?= CONFIG['languaje'] != 'jp' ?
        LANGUAJE['dashboard']['dashboard']['attention'][CONFIG['languaje']][0] .
        " <strong>{$httpGET['ap']}</strong> " .
        LANGUAJE['dashboard']['dashboard']['attention'][CONFIG['languaje']][1] :
        "<strong>{$httpGET['ap']}</strong> " .
        LANGUAJE['dashboard']['dashboard']['attention'][CONFIG['languaje']]
      ?>
    </section>
  <?php endif; ?>
<?php endif; ?>
<details class="con" <?= !isset($_GET['ap']) ? 'open' : (!file_exists($Web['directorio'] . "panel/app/{$_GET['ap']}/view.php") ? 'open' : '') ?>>
	<summary><?= LANGUAJE['global']['sections'][CONFIG['languaje']] ?></summary>
	<section class="flex-column botones-2 botones-mini">
		<?php foreach (require __DIR__.'/panel-lista-views.php' as $key => $value) { ?>
			<a href="?ap=<?= $value['apartado'] ?>"><i class="<?= $value['icono'] ?>"></i> <?= $value['texto'] ?></a>
		<?php } ?>
		<a target="_blank" href="<?= INFO['page-url'] ?>"><i class="fas fa-history"></i> <?= LANGUAJE['global']['update'][CONFIG['languaje']] ?></a>
		<a href="?ap=info"><i class="fas fa-tractor"></i> <?= LANGUAJE['global']['information'][CONFIG['languaje']] ?></a>
	</section>
</details>
<?php if(isset($_GET['ap']) && file_exists($File)){ require_once $File; } ?>