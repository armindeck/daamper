<section class="alert-pin">
    <section class="alert-pin__content">
        <header>
            <h2><?= Language("alert-pin-title", "alert") ?></h2>
            <hr class="my-16">
            <p><?= Language("alert-pin-main", "alert") ?></p>
        </header>
        <?php if(!isset(DATA->UserAll()[$_SESSION["id"]]["pin"])){ ?>
            <a class="boton-2" href="<?= "{$Web['directorio']}auth/config{$Web['config']['php']}" ?>?up=pin">Generar pin</a>
        <?php } else { ?>
        <div class="flex-evenly items-center">
            <input type="checkbox" class="show-key" id="show-pin" hidden>
            <label for="show-pin"><a class="boton-2"><i class="fas fa-eye"></i></a></label>
            <section class="campo flex-1 key-show">
                <p class="key-show__key" hidden><?= DATA->UserAll()[$_SESSION["id"]]["pin"] ?? Language("undefined"); ?></p>
                <p class="key-show__hidden">*********</p>
            </section>
        </div>
        <a href="?cerrar-sesion=true" class="boton"><i class="fas fa-sign-in-alt"></i> <?= Language("log-out") ?></a>
        <?php } ?>
    </section>
</section>