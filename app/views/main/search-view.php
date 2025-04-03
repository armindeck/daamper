<?php
$db = Database('other/search');
$search = isset($_GET['q']) ? SCRIPTS->normalizar2($_GET['q']) : false;
$search_by = isset($_GET['search-by']) && !empty($_GET['search-by']) && in_array($_GET['search-by'], $db['search-by']) ? SCRIPTS->normalizar2($_GET['search-by']) : $db['search-by'][1];
$search_limit = isset($_GET['search-limit']) && is_numeric($_GET['search-limit']) ? SCRIPTS->normalizar2($_GET['search-limit']) : $db['limit'];
$hide_images = isset($_GET['hide-images']) && !empty($_GET['hide-images']) ? true : false;
$hide_path = isset($_GET['hide-path']) && !empty($_GET['hide-path']) ? true : false;
$hide_title = isset($_GET['hide-title']) && !empty($_GET['hide-title']) ? true : false;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? SCRIPTS->normalizar2($_GET['page']) : 1;
?>
<section style="padding: 6px;">
    <form class="formulario flex-column" style="margin: 0px auto; max-width: 1024px;" action="<?= $Web['directorio'] ?>search<?= $Web['config']['php'] ?>" method="get">
        <input class="campo" type="search" name="q" minlength="4" maxlength="255" value="<?= $search ?? '' ?>" placeholder="<?= Language('search') ?>" required>
        <?php $search_options = []; foreach ($db['search-by'] as $buscar){
            $search_options[$buscar] = Language($buscar);
        } ?>
        <?= pSelect(["value" => $search_by, "name" => 'search-by', "texto" => Language("search-by"), "label" => true, "class_label" => 'flex-between',
            "option" => $search_options
            ]).
            pInput(["name" => "search-limit", "value" => $search_limit, "type" => "number", "label" => true, "texto" => Language("limit"), "class_label" => "flex-between", "class" => "form-campo-pequeno", "min" => 10, "max" => 50])
        ?>
        <section>
            <?= Language('disguise') ?>:
            <?= pCheckboxBoton(["nameidclass" => "hide-images", "texto" => Language("images"), "checked" => $hide_images]) ?>
            <?= pCheckboxBoton(["nameidclass" => "hide-title", "texto" => Language("title"), "checked" => $hide_title]) ?>
            <?= pCheckboxBoton(["nameidclass" => "hide-path", "texto" => Language("route"), "checked" => $hide_path]) ?>
        </section>
        <input class="boton" type="submit" value="&#xf002 <?= Language('search') ?>">
        <hr><span style="font-size: 12px;">v<?= VERSION['other']['search']['version'] . ' ~ ' . VERSION['other']['search']['updated'] ?></span>
    </form>
</section>
<?php if ($search && strlen($search) >= 4): ?>
<hr>
<section class="flex-evenly" style="gap: 8px; padding: 4px; <?= $hide_images ? 'margin: 0px auto; max-width: 1024px;' : '' ?>">
    <?php // Busqueda
    $archivos = glob($Web['directorio'].'app/database/publicaciones/*.php', GLOB_BRACE);
    sort($archivos, SORT_NATURAL | SORT_FLAG_CASE);
    $mostrar = [];
    for($i = 0; $i < count($archivos); $i++) {
        if(!in_array(basename($archivos[$i]), $db["remove"])){
            include $archivos[$i];
            
            if ($search_by == 'title') {
                if(strtolower($search) == strtolower($AC['titulo'])){
                    $mostrar[] = $archivos[$i];
                    break;
                }
            }
            if (in_array($search_by, ["title-tags", "tags", "description"])) {
                $search_array = explode(" ", strtolower($search));
                $busca = match (true) {
                    $search_by == 'title-tags' => 'titulo',
                    $search_by == 'tags' => 'meta_etiquetas',
                    $search_by == 'description' => 'descripcion',
                };
                $titulo_array = explode(" ", strtolower($AC[$busca]));
                foreach ($search_array as $search_titulo) {
                    if(strlen($search_titulo) >= 4){
                        foreach ($titulo_array as $titulo) {
                            if (strpos($titulo, $search_titulo) !== false) {
                                if(!in_array($archivos[$i], $mostrar)){
                                    $mostrar[] = $archivos[$i];
                                }
                                break;
                            }
                        }
                    }
                }
            }
            unset($AC); unset($ACR);
        }
    }
    
    echo count($mostrar) == 0 ? '<section class="con t-center">'.Language('no-results').'</section>' : '';

    if(count($mostrar) > 0){
        $limit = $db['limit'];
        $min = ($page - 1) * $limit;
        $max = $min + $limit;
        for($i = $min; $i < $max; $i++) { if( isset($mostrar[$i]) && file_exists($mostrar[$i])){ include $mostrar[$i]; ?>
            <a class="boton-2 flex-column" style="<?= !$hide_images ? 'max-width: 350px;' : 'width: 100%;' ?> flex-grow: 1; gap: 10px;" target="_blank" href="<?= $ACR['db_ruta'] ?>">
                <?php if(!$hide_images): ?>
                    <img width="100%" src="<?= $AC['miniatura'] ?>" style="border-radius: 4px;" loading="lazy">
                <?php endif; ?>
                <?php $calc = $hide_images + $hide_path;  if(!$hide_title || $hide_title && $calc == 2): ?>
                    <h3><?= $AC['titulo'] ?></h3>
                <?php endif; ?>
                <?= !in_array($search_by, ['title', 'title-tags']) && in_array($search_by, $db['search-by']) ? "<p>{$AC[$busca]}</p>" : '' ?>
                <?php if(!$hide_path): ?>
                    <section class="t-12" style="margin-top: auto;"><hr><?= str_replace(".php", "", $ACR['db_ruta']) ?></section>
                <?php endif; ?>
            </a>
    <?php unset($AC); unset($ACR); } } } ?>
</section>
<section class="con t-center">
    <?php $lista = ["q" => $search, "search-by" => $search_by, "hide-images" => $hide_images, "hide-path" => $hide_path, "hide-title" => $hide_title];
        $total_paginas = ceil(count($mostrar) / $db['limit']);
        for ($i = 1; $i <= $total_paginas; $i++) {
            echo "<a class='".($i == $page ? 'boton' : 'boton-2')."' href='?";
            foreach ($lista as $key => $value) {
                echo !empty($value) ? $key . "=" . $value . "&" : "";
            }
            echo "page=$i'>$i</a>";
        }
    ?>
</section>
<?php endif; ?>