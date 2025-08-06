<?php $rules_admin = Daamper::$data->Config("rules")["admin"]; ?>
<?php if(!isset($_GET['ap'])): ?>
	<section class="con">
        <strong><?= Language(['dashboard', 'wellcome-dashboard'], 'dashboard') ?></strong><hr>
        <?= Language(['dashboard', 'text'], 'dashboard') ?>
    </section>
<?php endif; ?>
<?php if(isset($_GET['ap'])):
  $httpGET['ap'] = Daamper::$scripts->normalizar2($_GET['ap']);
  $File = __DIR__ . "/../admin/{$httpGET['ap']}-view.php";
  if(!file_exists($File)): ?>
    <section class="con">
      <strong><?= Language('attention') ?></strong><hr>
      <?= Language(['dashboard', 'attention'], 'dashboard', ['value' => "<strong>".$httpGET['ap']."</strong>"]) ?>
    </section>
  <?php endif; ?>
<?php endif; ?>
<details class="con" <?= !isset($_GET['ap']) ? 'open' : (!file_exists($File) ? 'open' : '') ?>>
	<summary><?= Language('sections') ?></summary>
	<section class="flex-column botones-2 botones-mini">
		<?php if (isset($rules_admin[strtolower($_SESSION["rol"])])) {
      foreach (require __DIR__.'/admin-list-view.php' as $key => $value) {
        if(in_array($value['apartado'], $rules_admin[strtolower($_SESSION["rol"])])) { ?>
          <a href="?ap=<?= $value['apartado'] ?>"><i class="<?= $value['icono'] ?>"></i> <?= $value['texto'] ?></a>
        <?php }
      }
    } ?>
		<a target="_blank" href="<?= Daamper::$info['page-url'] ?>"><i class="fas fa-history"></i> <?= Language('update') ?></a>
		<a href="?ap=info"><i class="fas fa-tractor"></i> <?= Language('information') ?></a>
	</section>
</details>
<?php if(isset($_GET['ap'])){
  if (isset($rules_admin[strtolower($_SESSION["rol"])]) && in_array($_GET['ap'], $rules_admin[strtolower($_SESSION["rol"])])){
    if(file_exists($File)){ require_once $File; }
  } elseif(file_exists(RAIZ . "app/views/admin/" . $_GET["ap"] . "-view.php")) {
    echo "<section class='con t-center'>".(Language(['dashboard', 'higher-role-required'], 'dashboard'))."</section>";
  }
} ?>