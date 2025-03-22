<?php if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])): ?>
<?php /* -------------------------------- CONTENIDO ----------------------------------- */ ?>

<?php # CONTENIDO
  global $AX, $AXR;
  if (!isset($AXR['fecha_publicado'])) {
    $AXR['fecha_publicado'] = SCRIPTS->fecha_hora();
  }
  if (isset($AX['contenido']) && !empty($AX['contenido'])) {
    if (isset($AX['tipo'])) {
      echo in_array(strtolower($AX['tipo']), ['', 'normal']) ? '<div class="con">' : '';
      if (in_array(strtolower($AX['tipo']), ['blog', 'normal-blog'])) {
        require_once __DIR__ . '/views/blog-views.php';
      }
    } ?>
	<?= SCRIPTS->comandos($Web, PlantillaComandos($AX['contenido'], 0, 0)) ?>
	<?= isset($AX['tipo']) && in_array(strtolower($AX['tipo']), ['', 'normal', 'blog', 'normal-blog']) ? (in_array(strtolower($AX['tipo']), ['blog']) && isset($AXR['fecha_modificado']) && !empty($AXR['fecha_modificado']) ? '<hr><small>' . $AXR['fecha_modificado'] . '</small>' : '') . '</div>' : ''; ?>
	<?= isset($AX['tipo']) && in_array(strtolower($AX['tipo']), ['blog', 'normal-blog']) ? '</div>' : ''; ?>
<?php } ?>


<?php # LISTA DE ENTRADAS
  if ($AX['archivo'] == 'index.php') {
    require_once __DIR__ . '/function/lista-contenido.php';
    $lista = file_exists(__DIR__ . '/function/lista-publicaciones.php') ? require_once __DIR__ . '/function/lista-publicaciones.php' : [];
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
            'app/database/publicaciones/publicaciones' . (!empty($mostrar[$j]) ? '-' . $mostrar[$j] : '') . '.php',
            'entrada-' . (!empty($poster[$mostrar[$j]]) ? 'poster' : 'normal'),
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