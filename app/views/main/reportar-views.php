<?php
if ($Web['ruta_completa'] != '../../panel/procesa/procesa.creador.borrador.php' && $Web['ruta'] == 'reportar.php') {
    if (!isset($_SESSION['id'])) { ?>
        <section class="con">Inicie sesión o cree una cuenta para reportar el comentario.</section>
        <?php return;
    }
    if (isset($_GET['r']) && !empty($_GET['r'])) {
        $get['r'] = SCRIPTS->normalizar2($_GET['r']);
        $id = $get['r'];
        $file_comentarios = $Web['directorio'] . AppDatabase('comentarios/comentarios');
        $file_comentarios_extras = $Web['directorio'] . AppDatabase('comentarios/comentarios_extras');
        $comentarios = 0;
        if (file_exists($file_comentarios)){ $comentarios = require_once $file_comentarios; }
        if (file_exists($file_comentarios_extras)){ require_once $file_comentarios_extras; }
        if (count($comentarios) <= 0) { ?>
            <section class="con" style="text-align: center;">¡Oh! ~ Parece que todavía no hay comentarios!</section>
        <?php }
        for ($i = 1; $i <= count($comentarios); $i++) {
            if (md5('R+_' . $i . '-W') == $id) { $id = $i; $encontro = true; break; }
        }
        if (!isset($encontro)) { ?>
            <section class="con" style="text-align: center;">¡Oh! ~ Parece que el comentario que va a reportar no existe!</section>
        <?php return; }
        echo '<div class="panel">';
        require __DIR__ . '/comentario.views.php';
        Comentario($comentarios[$id]);
        if ($comentarios[$id]['estado'] == 'publico') { ?>
            <form method="post" action="./procesa/procesa.reportar.php">
                <strong>Reportar comentario 😨</strong><hr>
                Movitos:
                <select name="motivos">
                    <option value="acoso">Acoso</option>
                    <option value="engano">Engaño</option>
                    <option value="spam">Spam</option>
                    <option value="violencia">Violencia</option>
                    <option value="otro">Otro</option>
                </select>
                <?= pTextarea(['name'=>'motivos_texto','placeholder'=>'Motivos de mi reporte...','minlength'=>4,'maxlength'=>500,'label'=>true,'texto'=>'Respuesta','value'=> '','required'=>true]) ?>
                <input type="hidden" name="token-comentario" minlength="5" maxlength="100" value="<?= $get['r'] ?>" required><hr>
                <?php $a=rand(1,15); $b=rand(1,15); $c=$a+$b; ?>
                <label>Cuanto es <?= $a.' + '.$b; ?>: <input type="number" min="1" max="99" maxlength="1" name="resultado" pattern="[0-9]" required></label>
                <input type="hidden" name="resultado_verificar" value="<?= md5('R+_'.$c.'-W'); ?>"><hr>
                <input type="submit" class="boton" name="reportar" value="Reportar">
            </form>
        <?php }
        echo '</div>';
    }
}
?>