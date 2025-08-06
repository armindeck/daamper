<?php if (!isset($_GET['view']) && !isset($_GET['view-main']) || isset($_GET['view']) && in_array($_GET['view'], ['comentarios'])): ?>
<aside class="panel div-comentarios" <?= isset($_GET['view']) ? 'style="padding: 15px 6px;"' : '' ?>>
<?php
$file_comentarios = $Web['directorio'] . "database/comment/comment.json";
$file_comentarios_extras = $Web['directorio'] . "database/comment/extras.json";
$comentarios = Daamper::$scripts->UnirArrays(Daamper::$data->Comment() ?? [], Daamper::$data->Comment("extras") ?? []) ?? [];

if (count($comentarios) <= 0) { ?>
    <div class="form" style="text-align: center;"><?= Language('no-comments', 'form') ?></div>
<?php } else {
    $comentarios_estable = $comentarios;
    $comentarios = isset($_GET['orden_comentarios']) && $_GET['orden_comentarios'] === 'desc' ? array_reverse($comentarios) : $comentarios;
    $cantidad = isset($_GET['cantidad_comentarios']) && is_numeric($_GET['cantidad_comentarios']) && $_GET['cantidad_comentarios'] <= count($comentarios) ?
        Daamper::$scripts->normalizar2($_GET['cantidad_comentarios']) : count($comentarios);
    if ($comentarios > 10) { ?>
    <?php if (!isset($_GET['view'])): ?>
    <form method="get">
        <section>
            <?= $Web['ruta_completa'] == '../admin/admin.php' ? "<input name='ap' value='comments' hidden>" : '' ?>
            <label><?= Language('sort-by') ?> <select name="orden_comentarios">
                <?php foreach (["asc" => "ascending", "desc" => "descending"] as $key => $value) {
                    echo '<option value="'.$key.'" '.(isset($_GET["orden_comentarios"]) && $_GET["orden_comentarios"] == $key ? "selected" : "").'>'. Language($value) .'</option>';
                } ?>
                </select>
            </label>
            <label><?= Language('quantity') ?> <select name="cantidad_comentarios">
                <?php foreach ([10, 30, 50, 100, 130, 150, 200, "auto"] as $key => $value) {
                    echo '<option value="'.($value).'" '.(isset($_GET["cantidad_comentarios"]) && $_GET["cantidad_comentarios"] == $value ? "selected" : "").'>'.($value == "auto" ? Language("auto") : $value).'</option>';
                } ?>
                </select>
            </label>
            <input class="boton" type="submit" value="<?= Language('filter') ?>">
        </section>
    </form>
    <?php endif; ?>
    <?php }
    $i = 0;
    $sigue = true;
    $responder = [];
    require_once __DIR__. '/comentario-view.php';
    foreach ($comentarios as $key => $value) {
        $sigue_one = false;
        if ($value['ruta'] == $Web['ruta'] && empty($value['id_comentario'])) { $sigue_one = true; } else { $sigue_one = false; }
        if ($Web['ruta_completa'] == '../admin/admin.php' || isset($_GET['view']) && $value['ruta'] == $Web['ruta']) {
            $sigue_one = true;
        }
        if ($sigue_one){
            if (isset($_GET['cantidad_comentarios']) && is_numeric($_GET['cantidad_comentarios']) && $_GET['cantidad_comentarios'] <= count($comentarios)) {
                $sigue = $i < $_GET['cantidad_comentarios'] ? true : false;
            }
            if ($sigue) { ?>
                <?php if(isset($_GET['view']) || $Web['ruta_completa'] == '../admin/admin.php'): ?>
                <section class="flex-between t-12 mx-4" style="width: 100%; max-width: 800px;">
                    <span><?= Language('route') ?>:</span>
                    <a target="_blank" href="<?= $Web['directorio'].str_replace(".php", "", $value['ruta']) . $Web['config']['php'] ?>"><?= str_replace(".php", "", $value['ruta']) ?></a>
                </section>
                <?php endif; ?>
                <?= Comentario($value) ?>
                <?php if ($Web['ruta_completa'] != '../admin/admin.php'): ?>
                <details open style="width: 100%; max-width: 800px;" class="mx-4"><summary class="t-14"><?= Language('comments') ?></summary>
                    <section class="panel form-comentarios">
                    <?php foreach ($comentarios_estable as $key2 => $value2) {
                        if ($value2['ruta'] == $value['ruta'] && $value2['id_comentario'] == $value['id']) {
                            Comentario($value2);
                        }
                    } ?>
                    </section>
                </details>
                <?php endif; ?>
            <?php $i++; }
        }
    }
}
?>
</aside>
<?php endif; ?>