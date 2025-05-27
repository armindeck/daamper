<?php global $AXR, $AX; $usu = DATA->UserAll(); ?>
<div class="con con-blog <?= in_array(strtolower($AX['tipo']), array('blog', 'normal-blog')) ? 'con-blog--max-size' : '' ?>">
    <div class="blog">
        <section class="con-blog__miniatura">
            <img style="border-radius: 4px;" src="<?= $Web['config']['https_imagen'] . $AX['miniatura'] ?>">
        </section>
        <br>
        <?php if (strtolower($AX['tipo']) == 'blog'): ?>
        <h1><?= $AX['titulo'] ?></h1>
        <section class="con-blog__header">
            <h3 class="con-blog__published">
                <?php $avatar = isset($AXR['id_publicador']) && isset($usu[$AXR['id_publicador']]['usuario']) && file_exists($Web['directorio'].AssetsImg('avatar/'.$usu[$AXR['id_publicador']]['usuario'] . '.jpg')) ? 'avatar/' . $usu[$AXR['id_publicador']]['usuario'] . '.jpg' : 'avatar-profile.png'; ?>
                Por: <img loading="lazy" width="24" height="24" style="border-radius: 50%; margin: 0px 4px;" src="<?= $Web['config']['https_imagen'] . AssetsImg($avatar) ?>">
                <?= isset($AXR['id_publicador']) && isset($usu[$AXR['id_publicador']]['nombre']) ? $usu[$AXR['id_publicador']]['nombre'] : Language("user") ?>
            </h3>
            <h3><?= str_replace('/','.', substr($AXR['fecha_publicado'], 0, 10)) ?></h3>
        </section>
        <br><?= $AX['fragmento'] ?><br><br>
        <?php endif; ?>