<label>
  <input type="checkbox" hidden>
  <a><i class="fa fa-search"></i></a>
  <div class="sub">
    <form class="formulario flex items-start" style="border: 0; border-color: transparent; border-style: none; box-shadow: 0px 0px 0px 0px transparent;" action="<?= $Web['directorio'] ?>search<?= $Web['config']['php'] ?>" method="get">
      <div class="flex flex-between w-100p">
        <input class="campo flex-1" type="search" name="q" minlength="4" maxlength="255" value="<?= isset($_GET['q']) ? Daamper::$scripts->normalizar2($_GET['q']) : '' ?>" placeholder="<?= Language('search') ?>" required>
        <input type="hidden" name="search-by" value="title-tags">
        <button type="submit" value="true" class="boton"><i class="fas fa-search"></i></button>
      </div>
    </form>
  </div>
</label>