<label>
  <input type="checkbox" hidden>
  <a><i class="fa fa-language"></i></a>
  <div class="sub">
    <nav>
      <?php foreach (Daamper::$data->Config('language')['global']['languages-options'][(isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language'])] as $key => $value) { ?>
        <a href="?language=<?= $key ?>"><?= $key == (isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language']) ? '<i class="fas fa-check"></i> ' : '' ?><?= $value ?></a>
      <?php } ?>
    </nav>
  </div>
</label>