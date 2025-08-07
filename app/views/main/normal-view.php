<?php if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])): ?>
<?php /* -------------------------------- CONTENIDO ----------------------------------- */ ?>

<?php # CONTENIDO
  global $AX, $AXR;
  if (!isset($AXR['fecha_publicado'])) {
    $AXR['fecha_publicado'] = Daamper::$scripts->fecha_hora();
  }
  if (isset($AX['contenido']) && !empty($AX['contenido'])) {
    if (isset($AX['tipo'])) {
      echo in_array(strtolower($AX['tipo']), ['', 'normal']) ? '<div class="con">' : '';
      if (in_array(strtolower($AX['tipo']), ['blog', 'normal-blog'])) { Daamper::views("main/blog"); }
    } ?>
	<?= Daamper::$scripts->Commands($AX['contenido']) ?>
	<?= isset($AX['tipo']) && in_array(strtolower($AX['tipo']), ['', 'normal', 'blog', 'normal-blog']) ? (in_array(strtolower($AX['tipo']), ['blog']) && isset($AXR['fecha_modificado']) && !empty($AXR['fecha_modificado']) ? '<hr><small>' . $AXR['fecha_modificado'] . '</small>' : '') . '</div>' : ''; ?>
	<?= isset($AX['tipo']) && in_array(strtolower($AX['tipo']), ['blog', 'normal-blog']) ? '</div>' : ''; ?>
<?php } ?>


<?php # LISTA DE ENTRADAS
  if ($AX['archivo'] == 'index.php' && file_exists(__DIR__."/../components/list-of-entries-view.php")) {
    require_once __DIR__."/../components/list-of-entries-view.php";
    $lista = file_exists(RAIZ . "database/creator/list-of-entries.json") ? Daamper::$data->Read("creator/list-of-entries") : [];
    $mostrar = [];
    $posicion = [];
    $poster = [];
    foreach ($lista as $key => $value) {
      if (
        isset($AX["mostrar-{$value['entrada']}"]) && !empty($AX["mostrar-{$value['entrada']}"]) &&
        isset($AX["posicion-{$value['entrada']}"]) && !empty($AX["posicion-{$value['entrada']}"])
      ) {
        $mostrar[$AX["posicion-{$value['entrada']}"]] = $value['entrada'];
        $posicion[$value['entrada']] = $AX["posicion-{$value['entrada']}"];
        $poster[$value['entrada']] = $value['poster'] ?? '';
        $titulo[$value['entrada']] = ['titulo' => $value['titulo'] ?? '', 'titulo-alternativo' => $value['titulo-alternativo'] ?? ''];
      }
    }
    if (in_array(trim($AX['ruta'], '/'), $mostrar) || trim($AX['ruta'], '/') == '') {
      for ($j = 1; $j <= count($mostrar); $j++) {
        $continua = false;
        if (empty($AX['ruta'])) {
          $continua = true;
        }
        if (!empty($AX['ruta']) && trim($AX['ruta'], '/') == $mostrar[$j]) {
          $continua = true;
          $ruta = true;
        }
        if ($continua) {
          listaContenido(
            $mostrar[$j],
            (!empty($poster[$mostrar[$j]]) ? 'poster' : 'normal'),
            $mostrar[$j],
            $lista,
            $titulo[$mostrar[$j]],
            $AX['ruta']
          );
          if (isset($ruta)) {
            $continua = false;
            break;
          }
        }
      }
      echo '<div style="margin-bottom: 15px;"></div>';
    }
  } ?>

<?php /* -------------------------------- CONTENIDO ----------------------------------- */ ?>
<?php endif; ?>
<?php FormComentario() ?>