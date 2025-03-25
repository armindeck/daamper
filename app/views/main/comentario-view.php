<?php function Comentario($value){ global $Web; ?>
<?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'reportar.php'): ?>
<input type="checkbox" class="responder-comentario" id="responder-comentario-<?= md5('R+_' . $value['id'] . '-W') ?>" hidden>
<?php endif; ?>
<div id="<?= md5('R+_' . $value['id'] . '-W') ?>" class="form comentarios"<?= !empty($value['id_comentario']) ? ' style="width: 95%; max-width: 800px;"' : '' ?>>
    <?php if ($value['estado'] == 'publico'){ ?>
    <header>
        <div>
        <?= !empty($value['id_usuario']) ? '<a href="'. $Web['directorio'] .'p/'. usu[$value['id_usuario']]['usuario'] . $Web['config']['php'] .'">' : '' ?>
        <img loading="lazy" width="25" style="border-radius: 50%;" src="<?php
            if (!empty($value['id_usuario'])) {
                echo file_exists($Web['directorio'] . AssetsImg('avatar/' . usu[$value['id_usuario']]['usuario'] . '.jpg')) ?
                    $Web['directorio'] . AssetsImg('avatar/' . usu[$value['id_usuario']]['usuario'] . '.jpg') :
                    $Web['directorio'] . AssetsImg('avatar/avatar_default.png');
            } else { echo $Web['directorio'] . AssetsImg('avatar/avatar_default.png'); }
        ?>">
        <strong>
            <?= !empty($value['id_usuario']) ? usu[$value['id_usuario']]['nombre'] : $value['apodo'] ?>
            <?= !empty($value['id_usuario']) && strtolower(usu[$value['id_usuario']]['rol']) != 'usuario' ? '<span style="color: var(--a-hover-co); font-size: 12px;">' . usu[$value['id_usuario']]['rol'] . '</span>' : '' ?>
        </strong>
        <?= !empty($value['id_usuario']) ? '</a>' : '' ?>
        <span style="font-size: 12px; font-style: italic;"> ~ <?= str_replace('/', '-', $value['fecha']) ?></span>
        </div>
        <?php if ($Web['ruta'] != 'reportar.php') { ?>
        <form method="post" action="<?= $Web['directorio'] ?>procesa/procesa.reaccionar.php">
            <?= pInput(['type' => 'hidden', 'placeholder' => 'Token', 'name' => 'token-comentario', 'value' =>  md5('R+_' . $value['id'] . '-W'), 'minlength' => '4', 'maxlength' => 30, 'required' => true, 'des_session' => true]) ?>
            <?php
            foreach (['me_gusta' => '&#xf164;', 'no_me_gusta' => '&#xf165;'] as $item => $item_value) {
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
                echo "<input $style_input type='submit' name='$item' value='$item_value'>";
                echo '</label> ';
            }
            ?>
        </form>
        <?php } ?>
    </header><hr>
    <p>
    <?php
    # BUSCAR UN USUARIO CON EL @
    $comentario_text = preg_replace_callback('/@(\S+)/', function ($matches) use ($Web) {
        $username = $matches[1];
        foreach (usu as $usuario) {
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
            echo "<a style='font-size: 12px;' target='_blank' title='Sera dirigido a: {$value['enlace']}' href='{$value['enlace']}'>";
            $maximo = 25;
            echo substr($value['enlace'], 0, $maximo);
            if (strlen($value['enlace']) > $maximo) {
                echo '...';
            }
            echo "</a>";
        } ?>
        <?= $Web['ruta'] != 'reportar.php' ? '<hr>' : ''; ?>
    </section>
    <footer>
        <?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'reportar.php'){ ?>
        <?php if (!isset($_GET['view'])){ ?><label for="responder-comentario-<?= md5('R+_' . $value['id'] . '-W') ?>">Responder</label><?php } else { echo '<span></span>'; } ?>
        <?php } else { echo '<label></label>'; } ?>
        <?php if ($Web['ruta'] != 'reportar.php') { ?>
        <a target="_blank" href="<?= $Web['directorio'] . 'reportar' . $Web['config']['php'] . '?r=' . md5('R+_' . $value['id'] . '-W'); ?>">Reportar</a>
        <?php } ?>
    </footer>
    <?php } elseif ($value['estado'] == 'revision') {
        echo '<p>Este comentario se encuentra en revisión.</p>';
    } else {
        echo '<p>Este comentario fue eliminado.</p>';
    } ?>
</div>
<?php if (empty($value['id_comentario']) && $value['estado'] == 'publico' && $Web['ruta'] != 'reportar.php'): ?>
<div class="form-responder">
    <?php $responder['comentario'] = !empty($value['id_usuario']) ? '@' . (usu[$value['id_usuario']]['usuario']) : $value['apodo'] . ' '; ?>
    <?php $responder['id'] = $value['id']; $responder['ruta'] = $value['ruta']; require __DIR__ . "/form-comentar.views.php" ?>
</div>
<?php endif; ?>
    
<?php } ?>