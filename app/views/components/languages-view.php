<label>
  <input type="checkbox" hidden>
  <a><i class="fa fa-language"></i></a>
  <div class="sub">
    <nav>
      <?php foreach (Daamper::$data->Config('language')['global']['languages-options'][(isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language'])] as $key => $value) { ?>
        <a href="?language=<?= $key ?>"><span class="icon icon--left"><?= $key == (isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language']) ? '<i class="far fa-check-circle"></i> ' : '<i class="far fa-circle"></i>' ?></span><span class="text"><?= $value ?></span></a>
      <?php } ?>
    </nav>
  </div>
</label>