<style>
    .con-blog {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        <?= in_array(strtolower($AX['tipo']), array('blog', 'normal-blog')) ? 'max-width: 820px;' : '' ?>
    }
    .con-blog > .blog { border-radius: 0px; max-width: 820px; }
</style>
<div class="con con-blog">
    <div class="blog">
        <div style="text-align: center; margin-top: 30px;">
            <img style="border-radius: 4px;" src="<?= $Web['config']['https_imagen'] . $AX['miniatura'] ?>">
        </div>
        <br>
        <?php if (strtolower($AX['tipo']) == 'blog'){ ?>
        <h1><?= $AX['titulo'] ?></h1>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; opacity: .8;">
            <h3 style="display: flex; flex-wrap: wrap; justify-content: space-evenly; gap: 4px; align-items: center;">
                <?php $avatar = isset($AXR['id_publicador']) && isset(usu[$AXR['id_publicador']]['usuario']) && file_exists($Web['directorio'].AssetsImg('avatar/'.usu[$AXR['id_publicador']]['usuario'] . '.jpg')) ? usu[$AXR['id_publicador']]['usuario'] . '.jpg' : 'avatar_default.png'; ?>
                Por: <img loading="lazy" width="24" height="24" style="border-radius: 50%; margin: 0px 4px;" src="<?= $Web['config']['https_imagen'] . AssetsImg('avatar/'. $avatar) ?>">
                <?= isset($AXR['id_publicador']) && isset(usu[$AXR['id_publicador']]['nombre']) ? usu[$AXR['id_publicador']]['nombre'] : 'Usuario' ?>
            </h3>
            <h3><?= str_replace('/','.', substr($AXR['fecha_publicado'], 0, 10)) ?></h3>
        </div>
        <br><?= $AX['fragmento'] ?><br><br>
        <?php } ?>