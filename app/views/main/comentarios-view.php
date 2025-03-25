<?php if (!isset($_GET['view']) && !isset($_GET['view-main']) || isset($_GET['view']) && in_array($_GET['view'], ['comentarios'])): ?>
<aside class="panel div-comentarios" <?= isset($_GET['view']) ? 'style="padding: 15px 6px;"' : '' ?>>
<?php
$file_comentarios = $Web['directorio'] . AppDatabase('comentarios/comentarios');
$file_comentarios_extras = $Web['directorio'] . AppDatabase('comentarios/comentarios_extras');
$comentarios = [];
if (file_exists($file_comentarios)){ $comentarios = require_once $file_comentarios; }
if (file_exists($file_comentarios_extras)){ require_once $file_comentarios_extras; }
if (count($comentarios) <= 0) { ?>
    <div class="form" style="text-align: center;">¡Oh! ~ Parece que todavía no hay comentarios!</div>
<?php } else {
    $comentarios_estable = $comentarios;
    $comentarios = isset($_GET['orden_comentarios']) && $_GET['orden_comentarios'] === 'desc' ? array_reverse($comentarios) : $comentarios;
    $cantidad = isset($_GET['cantidad_comentarios']) && is_numeric($_GET['cantidad_comentarios']) && $_GET['cantidad_comentarios'] <= count($comentarios) ?
        SCRIPTS->normalizar2($_GET['cantidad_comentarios']) : count($comentarios);
    if ($comentarios > 10) { ?>
    <?php if (!isset($_GET['view'])): ?>
    <form method="get">
        <section>
            <?= $Web['ruta_completa'] == '../panel/panel.php' ? "<input name='ap' value='comentarios' hidden>" : '' ?>
            <label>Ordenar por <select name="orden_comentarios">
                    <option>asc</option>
                    <option>desc</option>
                </select>
            </label>
            <label>Cantidad <select name="cantidad_comentarios">
                    <option>10</option>
                    <option>30</option>
                    <option>50</option>
                    <option>100</option>
                    <option>130</option>
                    <option>150</option>
                    <option>200</option>
                    <option>auto</option>
                </select>
            </label>
            <input class="boton" type="submit" value="Filtrar">
        </section>
    </form>
    <?php endif; ?>
    <?php }
    $i = 0;
    $sigue = true;
    $responder = [];
    require_once __DIR__. '/comentario.views.php';
    foreach ($comentarios as $key => $value) {
        $sigue_one = false;
        if ($value['ruta'] == $Web['ruta'] && empty($value['id_comentario'])) { $sigue_one = true; } else { $sigue_one = false; }
        if (
            $Web['ruta_completa'] == '../panel/panel.php' && empty($value['id_comentario']) ||
            isset($_GET['view']) && empty($value['id_comentario']) && $value['ruta'] == $Web['ruta']
        ) {
            $sigue_one = true;
        }
        if ($sigue_one){
            if (isset($_GET['cantidad_comentarios']) && is_numeric($_GET['cantidad_comentarios']) && $_GET['cantidad_comentarios'] <= count($comentarios)) {
                $sigue = $i < $_GET['cantidad_comentarios'] ? true : false;
            }
            if ($sigue) { ?>
                <?php if(isset($_GET['view']) || $Web['ruta_completa'] == '../panel/panel.php'): ?>
                <section class="flex-between t-12" style="width: 100%; max-width: 800px;">
                    <span>Ruta:</span>
                    <a target="_blank" href="<?= $Web['directorio'].str_replace(".php", "", $value['ruta']) . $Web['config']['php'] ?>"><?= str_replace(".php", "", $value['ruta']) ?></a>
                </section>
                <?php endif; ?>
                <?= Comentario($value) ?>
                <details <?= $i < 1 ? 'open' : '' ?> style="width: 100%; max-width: 800px;"><summary class="t-14">Comentarios</summary>
                    <section class="panel form-comentarios">
                    <?php foreach ($comentarios_estable as $key2 => $value2) {
                        if ($value2['ruta'] == $value['ruta'] && $value2['id_comentario'] == $value['id']) {
                            Comentario($value2);
                        }
                    } ?>
                    </section>
                </details>
            <?php $i++; }
        }
    }
}
?>
</aside>
<?php endif; ?>