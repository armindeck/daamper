<?php
if ($Web['ruta_completa'] != '../../admin/process/creator.php' && $Web['ruta'] == 'report.php') {
    if (!isset($_SESSION['id'])) { ?>
        <section class="con"><?= Language('login-or-create-account-to-report', 'form') ?></section>
        <?php return;
    }
    if (isset($_GET['r']) && !empty($_GET['r'])) {
        $get['r'] = SCRIPTS->normalizar2($_GET['r']);
        $id = $get['r'];
        $comentarios = [];
        if (file_exists(DATA->CommentRoute())){ $comentarios = DATA->Comment(); }
        if (file_exists(DATA->CommentRoute(true))){ $comentarios = DATA->CommentAll(); }
        if (count($comentarios) <= 0) { ?>
            <section class="con" style="text-align: center;"><?= Language('no-comments', 'form') ?></section>
        <?php }
        for ($i = 1; $i <= count($comentarios); $i++) {
            if (SCRIPTS->SimpleToken($i) == $id) { $id = $i; $encontro = true; break; }
        }
        if (!isset($encontro)) { ?>
            <section class="con" style="text-align: center;"><?= Language('comment-to-report-not-exist', 'form') ?></section>
        <?php return; }
        echo '<div class="panel">';
        require __DIR__ . '/comentario-view.php';
        Comentario($comentarios[$id]);
        if ($comentarios[$id]['estado'] == 'publico') { ?>
            <form method="post" action="./process/report.php">
                <strong><?= Language('report-comment', 'form') ?></strong><hr><?= Language('', 'form') ?>
                <?= Language('reasons') ?>:
                <select name="motivos">
                    <option value="acoso"><?= Language('harassment', 'form') ?></option>
                    <option value="engano"><?= Language('deception', 'form') ?></option>
                    <option value="spam"><?= Language('spam', 'form') ?></option>
                    <option value="violencia"><?= Language('violence', 'form') ?></option>
                    <option value="otro"><?= Language('other') ?></option>
                </select>
                <?= pTextarea(['name'=>'motivos_texto','placeholder' => Language('report-reason', 'form'),'minlength'=>4,'maxlength'=>500,'label'=>true,'texto' => Language('response', 'form'),'value'=> '','required'=>true]) ?>
                <input type="hidden" name="token-comentario" minlength="5" maxlength="100" value="<?= $get['r'] ?>" required><hr>
                <?php $suma = SCRIPTS->SimpleSuma() ?>
                <label><?= Language('math-question', 'global', ['value' => $suma["a"], 'value2' => $suma["b"]]) ?>: <input type="number" min="<?= $suma["min-input"] ?>" max="<?= $suma["max-input"] ?>" maxlength="1" name="resultado" pattern="[0-9]" required></label>
                <input type="hidden" name="resultado_verificar" value="<?= SCRIPTS->SimpleToken($suma["c"]); ?>"><hr>
                <input type="submit" class="boton" name="reportar" value="<?= Language('report') ?>">
            </form>
        <?php }
        echo '</div>';
    }
}
?>