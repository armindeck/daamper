<?php #0.2.1 Estable 23.03.2025 
return ['archivo_plantilla' => 'daamper.php',
'cantidad_contenedores' => '11',
'cargar_scripts' => 'on',
'mostrar_contenedor_1' => 'on',
'tipo_contenedor_1' => 'components',
'cantidad_elementos_contenedor_1' => '1',
'nombre_contenedor_1' => 'Components',
'mostrar_elemento_1_contenedor_1' => 'on',
'contenido_campos_default_elemento_1_contenedor_1' => '[View=components/acciones]
<section>[View=components/up]</section>',
'ocultar_etiquetas_contenedor_campos_default_elemento_1_contenedor_1' => 'on',
'comandos_campos_default_elemento_1_contenedor_1' => '<details><summary>Redes sociales</summary>
  <section>[Form=InputEnlace name="redes-sociales" solo="icono"]</section>
</details>
<details><summary>Redes sociales recomendadas</summary>
  <section>[Form=InputEnlace name="redes-sociales-recomendadas"]</section>
</details>',
'mostrar_contenedor_2' => 'on',
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
<section>[View=components/temas]</section>
<section>[View=components/languages]</section>',
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
'mostrar_contenedor_5' => 'on',
'tipo_contenedor_5' => 'open-content',
'nombre_contenedor_5' => 'Open content',
'div_abrir_contenedor_5' => '<div class="content">',
'mostrar_contenedor_6' => 'on',
'tipo_contenedor_6' => 'main-header',
'cantidad_elementos_contenedor_6' => '1',
'nombre_contenedor_6' => 'Main header',
'div_abrir_contenedor_6' => '<main>',
'mostrar_elemento_1_contenedor_6' => 'on',
'contenido_campos_default_elemento_1_contenedor_6' => '[View=main/header]',
'mostrar_contenedor_7' => 'on',
'tipo_contenedor_7' => 'main',
'nombre_contenedor_7' => 'Main',
'mostrar_contenedor_8' => 'on',
'tipo_contenedor_8' => 'main-footer',
'nombre_contenedor_8' => 'Main footer',
'div_cerrar_contenedor_8' => '</main>',
'mostrar_contenedor_9' => 'on',
'tipo_contenedor_9' => 'article',
'cantidad_elementos_contenedor_9' => '6',
'nombre_contenedor_9' => 'Article',
'div_abrir_contenedor_9' => '<article class="article">',
'div_cerrar_contenedor_9' => '</article>',
'mostrar_elemento_1_contenedor_9' => 'on',
'contenido_campos_default_elemento_1_contenedor_9' => '[View=article]',
'ocultar_etiquetas_contenedor_campos_default_elemento_1_contenedor_9' => 'on',
'mostrar_elemento_2_contenedor_9' => 'on',
'titulo_campos_default_elemento_2_contenedor_9' => 'Administrador',
'contenido_campos_default_elemento_2_contenedor_9' => '<section>[Return=InputEnlace name="admin"]</section>
<small>[Return=InputEnlace name="donar"]</small><hr>
<small>Sígueme</small>
<section>[Return=InputEnlace name="redes-sociales" contenedor="1" elemento="1" solo="icono"]</section>',
'comandos_campos_default_elemento_2_contenedor_9' => '<strong>Admin</strong>
[Form=InputEnlace name="admin"]
<strong>Donar</strong>
[Form=InputEnlace name="donar"]',
'mostrar_elemento_3_contenedor_9' => 'on',
'titulo_campos_default_elemento_3_contenedor_9' => '<a href="[Return=WebEnlace]" target="_blank">Actualizaciones <i class="fas fa-rss"></i></a>',
'contenido_campos_default_elemento_3_contenedor_9' => '[Return=WebVersionesOnline]',
'titulo_campos_default_elemento_4_contenedor_9' => 'Peticiones',
'contenido_campos_default_elemento_4_contenedor_9' => '<section style="width: 100%; height: 350px;">[Return=Iframe src="peticiones.php" get="view~comentarios&cantidad_comentarios~10&orden_comentarios~desc"]</section>',
'mostrar_elemento_5_contenedor_9' => 'on',
'titulo_campos_default_elemento_5_contenedor_9' => 'Paginas épicas',
'contenido_campos_default_elemento_5_contenedor_9' => '<small><section class="flex-column">
[Return=InputEnlace name="redes-sociales-recomendadas" contenedor="1" elemento="1"]
</section></small>',
'mostrar_elemento_6_contenedor_9' => 'on',
'titulo_campos_default_elemento_6_contenedor_9' => 'Extras',
'contenido_campos_default_elemento_6_contenedor_9' => '<small><i class="fas fa-eye"></i> [Return=Visitas] visitas</small><hr>
<small><i class="fas fa-history"></i> [Return=WebVersion&Estado]</small>',
'mostrar_contenedor_10' => 'on',
'tipo_contenedor_10' => 'close-content',
'nombre_contenedor_10' => 'Close content',
'div_cerrar_contenedor_10' => '</div>',
'mostrar_contenedor_11' => 'on',
'tipo_contenedor_11' => 'footer',
'cantidad_elementos_contenedor_11' => '4',
'nombre_contenedor_11' => 'Footer',
'div_abrir_contenedor_11' => '<footer class="footer">',
'div_cerrar_contenedor_11' => '</footer>',
'mostrar_elemento_1_contenedor_11' => 'on',
'titulo_campos_default_elemento_1_contenedor_11' => 'Acerca de <Return=NombreWeb >',
'contenido_campos_default_elemento_1_contenedor_11' => '<small>Pagina web para juegos, animes, proyectos, blogs y mucho más.</small><br><br>
<small>[Return=Copy]</small><br>
[Return=WebVersionCompleta]',
'mostrar_elemento_2_contenedor_11' => 'on',
'titulo_campos_default_elemento_2_contenedor_11' => 'Cosas épicas',
'contenido_campos_default_elemento_2_contenedor_11' => '<small>Disfruta de mas beneficios creando una [Return=InputEnlace name="auth-registrar"].<br>
También puedes elegir los temas que quieras.</small><br><br>
<small><section class="flex-column">
[Return=InputEnlace name="link-recomendado"]
</section></small>',
'comandos_campos_default_elemento_2_contenedor_11' => '<section>Auth [Form=InputEnlace name="auth-registrar"]</section>
<section>Recomendados [Form=InputEnlace name="link-recomendado"]</section>',
'mostrar_elemento_3_contenedor_11' => 'on',
'titulo_campos_default_elemento_3_contenedor_11' => 'Redes sociales',
'contenido_campos_default_elemento_3_contenedor_11' => '<section class="links-redes">
  [Return=InputEnlace name="redes-sociales" contenedor="1" elemento="1" solo="icono"]
</section>',
'mostrar_elemento_4_contenedor_11' => 'on',
'titulo_campos_default_elemento_4_contenedor_11' => 'Recomendados',
'contenido_campos_default_elemento_4_contenedor_11' => '<small><section class="flex-column">
[Return=InputEnlace name="redes-sociales-recomendadas" contenedor="1" elemento="1"]
</section></small>',
];
?>