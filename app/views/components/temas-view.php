<label>
  <input type="checkbox" hidden>
  <a><i class="fas fa-fill-drip"></i></a>
  <div class="sub">
    <nav>
      <?php $themes = Daamper::$scripts->optenerTemas("{$Web['directorio']}assets/css/{$Web["config"]["theme"]}");
      foreach ($themes as $theme) {
        $explode = str_replace([" ", "_"], "-", $theme);
        $explode = explode("-", $explode);
        $icon = count($explode) > 1 ? $explode[0] : $theme;
        $icon = match($icon){
          "light" => "sun",
          "dark" => "moon",
          default => "fill-drip"
        }; ?>
        <a href="?tema=<?= $theme ?>"><span class="icon icon--left"><i class="fas fa-<?= $icon ?>"></i></span><span class="text"><?= ucwords(str_replace(['-', '_'], ' ', $theme)) ?></span></a>
      <?php } ?>
    </nav>
  </div>
</label>