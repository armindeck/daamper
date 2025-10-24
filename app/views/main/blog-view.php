<div class="con con-blog con-blog--max-size">
    <div class="blog">
        <section class="con-blog__miniatura">
            <img style="border-radius: 4px;" src="<?= $Web['config']['https_imagen'] . $miniatura ?>">
        </section>
        <br>
        <?php if ($tipo == 'blog'): ?>
            <h1><?= $titulo ?></h1>
            <section class="con-blog__header">
                <h3 class="con-blog__published">
                    <?php
                    $avatar = $user_data && isset($user_data['usuario']) &&
                        file_exists($Web['directorio'] . Daamper::imgPath('avatar/' . $user_data['usuario'] . '.jpg')) ?
                            'avatar/' . $user_data['usuario'] . '.jpg' :
                            'avatar-profile.png';
                    ?>
                    Por: <img loading="lazy" width="24" height="24" style="border-radius: 50%; margin: 0px 4px;" src="<?= $Web['config']['https_imagen'] . Daamper::imgPath($avatar) ?>">
                    <?= $user_data && isset($user_data['nombre']) ? $user_data['nombre'] : Language("user") ?>
                </h3>
                <h3><?= str_replace('/','.', substr($fecha_publicado, 0, 10)) ?></h3>
            </section>
            <?= !empty($fragmento) ? "<br>{$fragmento}<br><br>" : "" ?>
        <?php endif; ?>
        <?php
        $contenido = Daamper::$scripts->Commands($contenido);
        echo Michelf\MarkdownExtra::defaultTransform($contenido);
        ?>

        <?= in_array($tipo, ['blog']) && !empty($fecha_modificado) ? "<hr><small style='font-size: small;'>{$fecha_modificado}</small>" : '' ?>
    </div>
</div>