<label>
  <input type="checkbox" hidden>
  <a><i class="fas fa-fill-drip"></i></a>
  <div class="sub">
    <nav>
      <?php $files = glob($Web['directorio'].'assets/css/template/daamper/theme/*.css');
      foreach ($files as $file) { $file = str_replace('.css', '', basename($file));
      $file_explode = explode('-', $file); ?>
        <a href="?tema=<?= $file ?>"><i class="fas fa-<?=
          $file_explode[0] == 'light' ? 'sun' : ($file_explode[0] == 'dark' ? 'moon' : 'fill-drip')
        ?>"></i> <?= ucwords(str_replace('-', ' ', $file)) ?></a>
      <?php } ?>
    </nav>
  </div>
</label>