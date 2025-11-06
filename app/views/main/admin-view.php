<?php // Dashboard
$data = Daamper::$data->Config("admin"); // Data
$user_rol = strtolower($_SESSION["rol"]); // Rol
$rules = $data["rules"] ?? []; // Rules
?>
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
		<?php if (isset($rules[$user_rol])) {
      foreach ($data["entries"] as $key => $value) {
        if(in_array($value['section'], $rules[$user_rol])) { ?>
          <a href="?ap=<?= $value['section'] ?>"><span class="icon icon--left"><i class="<?= $value['icon'] ?>"></i></span><span class="text"><?= Language($value['text']) ?></span></a>
        <?php }
      }
    } ?>
	</section>
</details>
<?php if(isset($_GET['ap'])){
  if (isset($rules[$user_rol]) && in_array($_GET['ap'], $rules[$user_rol])){
    if(file_exists($File)){ require_once $File; }
  } elseif(file_exists(RAIZ . "app/views/admin/" . $_GET["ap"] . "-view.php")) {
    echo "<section class='con t-center'>".(Language(['dashboard', 'higher-role-required'], 'dashboard'))."</section>";
  }
} ?>