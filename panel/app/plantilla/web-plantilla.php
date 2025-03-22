<?php #0.2.1 Estable 17.03.2025 
return ['archivo_plantilla' => 'daamper-simple.php',
'cantidad_contenedores' => '11',
'cargar_scripts' => 'on',
'mostrar_contenedor_1' => 'on',
'tipo_contenedor_1' => 'components',
'cantidad_elementos_contenedor_1' => '1',
'nombre_contenedor_1' => 'Components',
'mostrar_elemento_1_contenedor_1' => 'on',
'contenido_campos_default_elemento_1_contenedor_1' => '[View=components/acciones]',
'ocultar_etiquetas_contenedor_campos_default_elemento_1_contenedor_1' => 'on',
'comandos_campos_default_elemento_1_contenedor_1' => '<details><summary>Redes sociales</summary>
  <section>[Form=InputEnlace name="redes-sociales" solo="icono"]</section>
</details>
<details><summary>Redes sociales recomendadas</summary>
  <section>[Form=InputEnlace name="redes-sociales-recomendadas"]</section>
</details>',
'tipo_contenedor_2' => 'header',
'cantidad_elementos_contenedor_2' => '1',
'nombre_contenedor_2' => 'Header',
'div_abrir_contenedor_2' => '<header class="header" id="header">',
'div_cerrar_contenedor_2' => '</header>',
'mostrar_elemento_1_contenedor_2' => 'on',
'contenido_campos_default_elemento_1_contenedor_2' => '<section class="titulo">[Return=InputEnlace name="titulo"]</section>
<section>[Return=InputEnlace name="redes-sociales" contenedor="1" elemento="1" solo="icono"]</section>',
'ocultar_etiquetas_contenedor_campos_default_elemento_1_contenedor_2' => 'on',
'comandos_campos_default_elemento_1_contenedor_2' => '<details><summary>Titulo</summary>
  <section>[Form=InputEnlace name="titulo"]</section>
</details>',
'mostrar_contenedor_3' => 'on',
'tipo_contenedor_3' => 'header-bar',
'cantidad_elementos_contenedor_3' => '3',
'nombre_contenedor_3' => 'Header bar',
'div_abrir_contenedor_3' => '<header class="header-bar">',
'div_cerrar_contenedor_3' => '</header>',
'mostrar_elemento_1_contenedor_3' => 'on',
'contenido_campos_default_elemento_1_contenedor_3' => '<label for="check-sidebar"><a><i class="fas fa-bars"></i></a></label>',
'ocultar_etiquetas_contenedor_campos_default_elemento_1_contenedor_3' => 'on',
'mostrar_elemento_2_contenedor_3' => 'on',
'contenido_campos_default_elemento_2_contenedor_3' => '<section>[Return=InputEnlace name="title"]</section>',
'ocultar_etiquetas_contenedor_campos_default_elemento_2_contenedor_3' => 'on',
'comandos_campos_default_elemento_2_contenedor_3' => '<section><strong>Titulo</strong>
  <section>[Form=InputEnlace name="title" icono_position="right"]</section>
</section>',
'mostrar_elemento_3_contenedor_3' => 'on',
'contenido_campos_default_elemento_3_contenedor_3' => '<label>
  <input type="checkbox" hidden>
  <a><i class="fas fa-user-circle"></i></a>
  <div class="sub">
    <nav>
      [Return=InputEnlaceSesion name="nav-bar-sesion"]<i hidden></i>
      [Return=InputEnlaceNoSesion name="nav-bar-no-sesion"]
    </nav>
  </div>
</label>
<section>[View=components/temas]</section>',
'comandos_campos_default_elemento_3_contenedor_3' => '<section><strong>Redes</strong>
  <section>[Form=InputEnlace name="links"]</section>
</section>
<section><strong>Nav-bar no sesión</strong>
  <section>[Form=InputEnlace name="nav-bar-no-sesion"]</section>
</section>
<section><strong>Nav-bar sesión</strong>
  <section>[Form=InputEnlace name="nav-bar-sesion"]</section>
</section>',
'mostrar_contenedor_4' => 'on',
'tipo_contenedor_4' => 'sidebar',
'cantidad_elementos_contenedor_4' => '1',
'nombre_contenedor_4' => 'Sidebar',
'div_abrir_contenedor_4' => '<sidebar class="sidebar">',
'div_cerrar_contenedor_4' => '</sidebar>
<div class="overlay"></div>',
'mostrar_elemento_1_contenedor_4' => 'on',
'contenido_campos_default_elemento_1_contenedor_4' => '[View=sidebar]
<section class="links">
  [Return=InputEnlace name="sidebar-links-entradas"]
</section>
<footer>
  <section class="links-redes">
    [Return=InputEnlace name="redes-sociales" contenedor="1" elemento="1" solo="icono"]
  </section>
  <small>[Return=Copy]</small>
  [Return=WebVersionCompleta]
</footer>',
'div_abrir_campos_default_elemento_1_contenedor_4' => '<section>',
'div_cerrar_campos_default_elemento_1_contenedor_4' => '</section>',
'comandos_campos_default_elemento_1_contenedor_4' => '<section><strong>Entradas</strong>
  [Form=InputEnlace name="sidebar-links-entradas"]
</section>',
'tipo_contenedor_5' => 'open-content',
'nombre_contenedor_5' => 'Open content',
'div_abrir_contenedor_5' => '<div class="content">',
'tipo_contenedor_6' => 'main-header',
'cantidad_elementos_contenedor_6' => '1',
'nombre_contenedor_6' => 'Main header',
'div_abrir_contenedor_6' => '<main>',
'mostrar_elemento_1_contenedor_6' => 'on',
'contenido_campos_default_elemento_1_contenedor_6' => '[View=main/header]',
'mostrar_contenedor_7' => 'on',
'tipo_contenedor_7' => 'main',
'nombre_contenedor_7' => 'Main',
'tipo_contenedor_8' => 'main-footer',
'nombre_contenedor_8' => 'Main footer',
'div_cerrar_contenedor_8' => '</main>',
'tipo_contenedor_9' => 'article',
'cantidad_elementos_contenedor_9' => '1',
'nombre_contenedor_9' => 'Article',
'div_abrir_contenedor_9' => '<article class="article">',
'div_cerrar_contenedor_9' => '</article>',
'mostrar_elemento_1_contenedor_9' => 'on',
'titulo_campos_default_elemento_1_contenedor_9' => 'Información',
'contenido_campos_default_elemento_1_contenedor_9' => '<small><i class="fas fa-eye"></i> [Return=Visitas] visitas</small><hr>
<small><i class="fas fa-history"></i> [Return=WebVersion&Estado]</small>',
'tipo_contenedor_10' => 'close-content',
'nombre_contenedor_10' => 'Close content',
'div_cerrar_contenedor_10' => '</div>',
'mostrar_contenedor_11' => 'on',
'tipo_contenedor_11' => 'footer',
'cantidad_elementos_contenedor_11' => '1',
'nombre_contenedor_11' => 'Footer',
'div_abrir_contenedor_11' => '<footer class="footer">',
'div_cerrar_contenedor_11' => '</footer>',
'mostrar_elemento_1_contenedor_11' => 'on',
'contenido_campos_default_elemento_1_contenedor_11' => '<small>[Return=Copy]</small> [Return=WebVersionCompleta]',
'div_abrir_campos_default_elemento_1_contenedor_11' => '<section>',
'div_cerrar_campos_default_elemento_1_contenedor_11' => '</section>',
];
?>