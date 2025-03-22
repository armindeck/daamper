<?php if (!isset($_GET['view'])): ?>
<aside class="panel">
<form action="<?= $Web['directorio'] . 'procesa/procesa.comentar.php?ruta=' . (isset($responder['ruta']) ? $responder['ruta'] . ($Web['ruta_completa'] == '../panel/panel.php' ? '&sub-ruta=panel-comentarios' : '') : $Web['ruta'] . ($Web['ruta_completa'] == '../panel/panel.php' ? '&sub-ruta=panel-comentarios' : '')); ?>" method="post" class="formulario">
    <?php # Anonimo
    if (!isset($_SESSION['id'])) { ?>
    <h2><?= !isset($responder) ? 'Deja un comentario 😄' : 'Responder comentario 🙃' ?></h2><hr>
    <p>Tienes una cuenta? <a target="_blank" href="<?= $Web['directorio'] . 'auth/iniciar' . $Web['config']['php']; ?>">Inicia sesión</a> o <a target="_blank" href="<?= $Web['directorio'] . 'auth/registrar' . $Web['config']['php']; ?>">Registrate</a></p><hr>
    <strong style="opacity: .8;">Comentar anonimamente:</strong><hr>
    <?php echo
    pInput(['type' => 'text', 'placeholder' => 'Apodo', 'name' => 'apodo', 'minlength' => '4', 'maxlength' => 30, 'label' => false, 'texto' => 'Apodo:', 'required' => true])
        ;
    } else { ?>
    <h2 style="display: flex; flex-wrap: wrap; align-items: center; gap: 4px">
        <a target="_blank" style="text-decoration: none; display: flex; flex-wrap: wrap; align-items: center; gap: 4px" href="<?= $Web['directorio'] . 'p/' . usu[$_SESSION['id']]['usuario'] . $Web['config']['php'] ?>">
            <img loading="lazy" width="30" style="border-radius: 50%;" src="<?= file_exists($Web['directorio'] . AssetsImg("avatar/" . usu[$_SESSION['id']]['usuario']).'.jpg') ? $Web['directorio'] . AssetsImg("avatar/" . usu[$_SESSION['id']]['usuario']).'.jpg' : $Web['directorio'] . AssetsImg("avatar/avatar_default").'.png' ?>" alt="Avatar de <?= usu[$_SESSION['id']]['usuario'] ?>">
            <?= usu[$_SESSION['id']]['nombre'] ?>
        </a> <?= !isset($responder) ? 'deja un comentario 😉' : 'responde el comentario 😉' ?>
    </h2>
    <?php } ?>
    <details class="t-14"><summary>Emojis</summary><section><?= Views('components/emojis') ?></section></details>
    <?=
    pTextarea(['placeholder' => '¡Guau! Me gustaría... además como...', 'name' => 'comentario', 'value' => isset($responder['comentario']) ? $responder['comentario'].' ' : '', 'minlength' => '20', 'maxlength' => 5000, 'required' => true]).'<div>'.
    pInput(['type' => 'url', 'placeholder' => 'Enlace (opcional)', 'name' => 'enlace', 'minlength' => '4', 'maxlength' => 400, 'label' => false, 'texto' => 'Enlace:']).' '.
    pInput(['type' => 'url', 'placeholder' => 'Enlace imagen (opcional)', 'name' => 'enlace_imagen', 'minlength' => '4', 'maxlength' => 400, 'label' => false, 'texto' => 'Enlace imagen:']).'</div>'.
    pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token', 'value' =>  md5('R+_'.$Web['ruta'].'-W'), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]);
    if (isset($responder)) {
        echo pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token-responder', 'value' =>  md5('R+_'.$responder['id'].'-W'), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]);
    }
    ?><hr>
    <?php $a=rand(1,15); $b=rand(1,15); $c=$a+$b; ?>
    <label>Cuanto es <?= $a.' + '.$b; ?>: <input type="number" min="1" max="99" maxlength="1" name="resultado" pattern="[0-9]" required></label>
    <input type="hidden" name="resultado_verificar" value="<?= md5('R+_'.$c.'-W'); ?>"><hr>
    <input type="submit" name="<?= !isset($responder) ? 'comentar' : 'responder' ?>" value="<?= !isset($responder) ? 'Comentar' : 'Responder' ?>" class="boton"><hr>
    <span style="font-size: 12px;">v0.1.1 ~ 02.01.2025</span>
</form>
</aside>
<?php endif; ?>