<label>
  <input type="checkbox" hidden>
  <a><i class="fa fa-search"></i></a>
  <div class="sub">
    <form class="formulario" action="<?= $Web['directorio'] ?>search<?= $Web['config']['php'] ?>" method="get">
      <span><?= Language('search') ?>:</span>  
      <input class="campo" type="search" name="q" minlength="4" maxlength="255" value="<?= isset($_GET['q']) ? Daamper::$scripts->normalizar2($_GET['q']) : '' ?>" placeholder="<?= Language('search') ?>" required>
      <input type="hidden" name="search-by" value="title-tags">
      <input class="boton" type="submit" value="&#xf002 <?= Language('search') ?>">
    </form>
  </div>
</label>