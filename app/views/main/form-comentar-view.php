<?php if (!isset($_GET['view'])): ?>
<aside class="panel">
<form action="<?= $Web['directorio'] . 'process/comment.php?ruta=' . (isset($responder['ruta']) ? $responder['ruta'] . ($Web['ruta_completa'] == '../admin/admin.php' ? '&sub-ruta=admin-comments' : '') : $Web['ruta'] . ($Web['ruta_completa'] == '../admin/admin.php' ? '&sub-ruta=admin-comments' : '')); ?>" method="post" class="formulario">
    <?php # Anonimo
    if (!isset($_SESSION['id'])) { ?>
    <h2><?= !isset($responder) ? Language('leave-comment', 'form') : Language('reply-comment', 'form') ?></h2><hr>
    <p><?= Language('do-you-have-an-account', 'form') ?> <a target="_blank" href="<?= $Web['directorio'] . 'auth/iniciar' . $Web['config']['php']; ?>"><?= Language('login') ?></a> <?= Language('or') ?> <a target="_blank" href="<?= $Web['directorio'] . 'auth/registrar' . $Web['config']['php']; ?>"><?= Language('register') ?></a></p><hr>
    <strong style="opacity: .8;"><?= Language('comment-anonymously', 'form') ?></strong>
    <?php echo
    pInput(['type' => 'text', 'placeholder' => Language('nickname', 'form'), 'name' => 'apodo', 'minlength' => '4', 'maxlength' => 30, 'label' => false, 'texto' => Language('nickname', 'form'), 'required' => true])
        ;
    } else { $usu = Daamper::$data->UserAll() ?? []; ?>
    <h2 style="display: flex; flex-wrap: wrap; align-items: center; gap: 4px">
        <a target="_blank" style="text-decoration: none; display: flex; flex-wrap: wrap; align-items: center; gap: 4px" href="<?= $Web['directorio'] . 'p/' . $usu[$_SESSION['id']]['usuario'] . $Web['config']['php'] ?>">
            <img loading="lazy" width="30" style="border-radius: 50%;" src="<?= file_exists($Web['directorio'] . AssetsImg("avatar/" . $usu[$_SESSION['id']]['usuario']).'.jpg') ? $Web['directorio'] . AssetsImg("avatar/" . $usu[$_SESSION['id']]['usuario']).'.jpg' : $Web['directorio'] . AssetsImg("avatar-profile").'.png' ?>" alt="Avatar de <?= $usu[$_SESSION['id']]['usuario'] ?>">
            <?= $usu[$_SESSION['id']]['nombre'] ?>
        </a> <?= !isset($responder) ? Language('leaves-comment', 'form') : Language('replies-comment', 'form') ?>
    </h2>
    <?php } ?>
    <details class="t-14"><summary><?= Language('emojis') ?></summary><section><?= Views('components/emojis') ?></section></details>
    <?=
    pTextarea(['placeholder' => Language('wow-message', 'form'), 'name' => 'comentario', 'value' => isset($responder['comentario']) ? $responder['comentario'].' ' : '', 'minlength' => '20', 'maxlength' => 5000, 'required' => true]).'<div>'.
    pInput(['type' => 'url', 'placeholder' => Language('link').' ('.Language('optional').')', 'name' => 'enlace', 'minlength' => '4', 'maxlength' => 400, 'label' => false, 'texto' => Language('link')]).' '.
    pInput(['type' => 'url', 'placeholder' => Language('image-link').' ('.Language('optional').')', 'name' => 'enlace_imagen', 'minlength' => '4', 'maxlength' => 400, 'label' => false, 'texto' => Language('image-link')]).'</div>'.
    pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token', 'value' =>  Daamper::$scripts->SimpleToken($Web['ruta']), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]);
    if (isset($responder)) {
        echo pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token-responder', 'value' =>  Daamper::$scripts->SimpleToken($responder['id']), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]);
    }
    ?><hr>
    <?php $suma = Daamper::$scripts->SimpleSuma() ?>
    <label><?= Language('math-question', 'global', ['value' => $suma["a"], 'value2' => $suma["b"]]) ?>: <input type="number" min="<?= $suma["min-input"] ?>" max="<?= $suma["max-input"] ?>" maxlength="1" name="resultado" pattern="[0-9]" required></label>
    <input type="hidden" name="resultado_verificar" value="<?= Daamper::$scripts->SimpleToken($suma["c"]); ?>" required>
    <input type="hidden" name="new-token" value="<?= Daamper::$scripts->GenerateToken() ?>" required>
    <hr>
    <input type="submit" name="<?= !isset($responder) ? 'comentar' : 'responder' ?>" value="<?= !isset($responder) ? Language('comment') : Language('reply') ?>" class="boton"><hr>
    <span style="font-size: 12px;">v<?= Daamper::$version['other']['form-comment']['version'] . ' ~ ' . Daamper::$version['other']['form-comment']['updated'] ?></span>
</form>
</aside>
<?php endif; ?>