<?php function Comentario($value){ global $Web; $usu = Daamper::$data->UserAll() ?? []; ?>
<?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'report.php'): ?>
<input type="checkbox" class="responder-comentario" id="responder-comentario-<?= Daamper::$scripts->SimpleToken($value['id']) ?>" hidden>
<?php endif; ?>
<div id="<?= Daamper::$scripts->SimpleToken($value['id']) ?>" class="form comentarios <?= $value["estado"] != "publico" && $Web["ruta_completa"] == "../admin/admin.php" ? "comment-alert" : '' ?>"<?= !empty($value['id_comentario']) ? ' style="width: 95%; max-width: 800px;"' : '' ?>>
    <?php if ($value['estado'] == 'publico' || in_array($value['estado'], ['publico', 'revision']) && $Web["ruta_completa"] == "../admin/admin.php"){ ?>
    <header>
        <div>
        <?= !empty($value['id_usuario']) ? '<a href="'. $Web['directorio'] .'p/'. $usu[$value['id_usuario']]['usuario'] . $Web['config']['php'] .'">' : '' ?>
        <img loading="lazy" width="25" style="border-radius: 50%;" src="<?php
            if (!empty($value['id_usuario'])) {
                echo file_exists($Web['directorio'] . Daamper::imgPath('avatar/' . $usu[$value['id_usuario']]['usuario'] . '.jpg')) ?
                    $Web['directorio'] . Daamper::imgPath('avatar/' . $usu[$value['id_usuario']]['usuario'] . '.jpg') :
                    $Web['directorio'] . Daamper::imgPath('avatar-profile.png');
            } else { echo $Web['directorio'] . Daamper::imgPath('avatar-profile.png'); }
        ?>">
        <strong>
            <?= !empty($value['id_usuario']) ? $usu[$value['id_usuario']]['nombre'] : $value['apodo'] ?>
            <?= !empty($value['id_usuario']) && strtolower($usu[$value['id_usuario']]['rol']) != 'usuario' ? '<span style="color: var(--a-hover-co); font-size: 12px;">' . $usu[$value['id_usuario']]['rol'] . '</span>' : '' ?>
        </strong>
        <?= !empty($value['id_usuario']) ? '</a>' : '' ?>
        <span style="font-size: 12px; font-style: italic;"> ~ <?= str_replace('/', '-', $value['fecha']) ?></span>
        </div>
        <?php if ($Web['ruta'] != 'report.php') { ?>
        <form method="post" action="<?= $Web['directorio'] ?>process/reaction.php<?= $Web['ruta_completa'] == '../admin/admin.php' ? '?sub-ruta=admin-comments' : '' ?>">
            <?= pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token-comentario', 'value' =>  Daamper::$scripts->SimpleToken($value['id']), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]) ?>
            <?php
            foreach (['me_gusta' => 'thumbs-up', 'no_me_gusta' => 'thumbs-down'] as $item => $item_value) {
                echo '<label>';
                $cantidad = 0; $style_input = '';
                if (isset($value['reacciones'])) {
                    foreach ($value['reacciones'] as $reacciones => $reacciones_value) {
                        if(!empty($reacciones_value[$item])) { $cantidad++;
                            if (isset($_SESSION['id']) && $reacciones_value['id_usuario'] == $_SESSION['id']) {
                                $style_input = 'style="color: var(--a-co);"';
                            }
                        }
                    }
                }
                echo !empty($cantidad) ? $cantidad . ' ' : '';
                echo "<button $style_input type='submit' name='$item' value='true'><i class='far fa-$item_value'></i></button>";
                echo '</label> ';
            }
            ?>
        </form>
        <?php } ?>
    </header><hr>
    <p>
    <?php
    # BUSCAR UN USUARIO CON EL @
    $comentario_text = preg_replace_callback('/@(\S+)/', function ($matches) use ($Web, $usu) {
        $username = $matches[1];
        foreach ($usu as $usuario) {
            if ($usuario['usuario'] === $username) {
                return "<a target='_blank' href='{$Web['directorio']}p/$username{$Web['config']['php']}'>@$username</a>";
            }
        }
        return "@$username";
        
    }, $value['comentario']);
    # REEMPLAZAR EL \N POR <BR>
    $comentario_text = preg_replace('/(\n{3,})/', "\n\n", $comentario_text);
    $comentario_text = str_replace("\n", "<br>", $comentario_text);
    # MOSTRAR SIERTA CANTIDAD DE TEXTO
    $comentario_text = wordwrap($comentario_text, 50, " ", true);
    echo $comentario_text?>
    </p>
    <?= !empty($value['enlace']) || !empty($value['enlace_imagen']) ? '<hr>' : ''; ?>
    <section>
        <?= !empty($value['enlace_imagen']) ? "<center><img loading style='max-width: 100%;' src='{$value['enlace_imagen']}'></center>" : '' ?>
        <?= !empty($value['enlace_imagen']) && !empty($value['enlace']) ? '<hr>' : ''; ?>
        <?php if (!empty($value['enlace'])) {
            echo "<a style='font-size: 12px;' target='_blank' title='".Language('redirect-to', 'form', ['value' => $value['enlace']])."' href='{$value['enlace']}'>";
            $maximo = 25;
            echo substr($value['enlace'], 0, $maximo);
            if (strlen($value['enlace']) > $maximo) {
                echo '...';
            }
            echo "</a>";
        } ?>
        <?= $Web['ruta'] != 'report.php' ? '<hr>' : ''; ?>
    </section>
    <footer>
        <?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'report.php'){ ?>
        <?php if (!isset($_GET['view'])){ ?><label for="responder-comentario-<?= Daamper::$scripts->SimpleToken($value['id']) ?>"><?= Language('reply') ?></label><?php } else { echo '<span></span>'; } ?>
        <?php } else { echo '<label></label>'; } ?>
        <?php if ($Web['ruta'] != 'report.php') { ?>
        <a target="_blank" href="<?= $Web['directorio'] . 'report' . $Web['config']['php'] . '?r=' . Daamper::$scripts->SimpleToken($value['id']); ?>"><?= Language('report') ?></a>
        <?php } ?>
    </footer>
    <?php } elseif ($value['estado'] == 'revision') {
        echo '<p>'.Language('comment-under-review', 'form').'</p>';
    } else {
        echo '<p>'.Language('comment-deleted', 'form').'</p>';
    } ?>
    <?php if ($Web["ruta_completa"] == "../admin/admin.php"): ?>
        <hr>
        <form action="<?= $Web["directorio"] ?>admin/process/actions.php" method="post" class="flex-between">
            <input type="hidden" name="id_comentario" value="<?= Daamper::$scripts->hash($value["ruta"], $value["comentario"], $value["id"]) ?>" required>
            <label><span><?= Language("status") ?>:</span>
                <select name="estado_comentario">
                    <?php foreach (["publico" => "public", "revision" => "review", "eliminado" => "deleted"] as $key_aqui => $value_aqui) {
                        echo '<option value="'.$key_aqui.'" '.($value["estado"] == $key_aqui ? "selected" : "").'>'. Language($value_aqui) .'</option>';
                    } ?>
                </select>
            </label>
            <input class="boton-2" type="submit" name="procesa_comments" value="<?= Language("update") ?>">
        </form>
    <?php endif; ?>
</div>
<?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'report.php'): ?>
<div class="form-responder">
    <?php $responder['comentario'] = !empty($value['id_usuario']) ? '@' . ($usu[$value['id_usuario']]['usuario']) : $value['apodo'] . ' '; ?>
    <?php $responder['id'] = $value['id']; $responder['ruta'] = $value['ruta']; require __DIR__ . "/form-comentar-view.php" ?>
</div>
<?php endif; ?>
    
<?php } ?>