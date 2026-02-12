# Changelog
Descubre las nuevas novedades de daamper!

## [0.3.9 Stable] - 12/02/2026

- Nuvas mejoras para el panel administrativo:
    - Se cambio el diseño del apartado Configuración, ademas se unio el apartado Htaccess.
    - Actualice el archivo de las acciones para que se pudiera re-dirigir a las configuraciones cuando se actualice el htaccess.
    - Nuevo diseño para: (información, actualizaciones, explorador de archivos, subir imagen, anuncios, scripts, usuarios, editor).
    - Cambie el nombre de **Directorio** por **Explorador** y **Creador** por **Publicar**.
    - Elimine el apartado `Tema`.
    - Mejore el diseño del apartado creador, por ahora solo la parte superior.
    - Mejore y cambie el diseño de los formularios para publicar `normal`, `entrada anime`, `mirando anime` y `juego`.
- Corregi un bug con el cierre de la etiqueta label en los input antiguos.
- Ahora se puede usar el formato Markdown en la sinopsis de los animes y juego, ademas en la información extra en juego.

## [0.3.8 Stable] - 13/11/2025
Nuevo diseño del apartado Plantilla en el panel administrativo.

### ✨ Nuevas funciones

- Implementada la clase Template para el renderizado dinámico de vistas y manejo de comandos.
- Nuevos métodos para procesar contenedores y elementos según la configuración establecida.
- Soporte ampliado para comandos definidos en template-commands.json.

### 🧩 Nuevos componentes

- dropdown-view.php: componente para menús desplegables interactivos con casillas de verificación y soporte multilenguaje.

- modal-view.php: componente para ventanas modales con contenido dinámico y compatibilidad con traducciones (título y botón de cierre).

### 🧹 Mantenimiento

- Agregado template-commands.json con nuevos mapeos y soporte para los componentes recientemente añadidos.

## [0.3.7 Stable] - 05/11/2025
Limpieza, mejoras visuales y eliminación de API

La mayoría de las mejoras las tome de la versión 0.4.0 dev. 

- Mejoras en las plantillas y estilos predeterminadas.
- Ahora la pagina principal tiene las instrucciones y configuraciones.
- Ahora en los idioma se mostrara un circulo con un check en medio y los demás estarán con un circulo vacío.
- Ahora se mostrara un texto en la alerta de guardar pin/cambiar pin: *Por favor cambie el pin de recuperación, está usando el predeterminado*
- Quite todo lo relacionado con la Api, incluyéndola.
    - No es bueno usarla por la seguridad, además mostraba datos sensibles.
- Los sub-menus de la barra superior se mostraran mejor.
- El sidebar por defecto esta oculto, ahora se usa un sub menú. 
- Para mostrar el sidebar acceda al panel, sección plantilla: 
    - Sidebar: Habilite el boton mostrar
    - Header bar, Elementos, Elemento #1: Habilite el boton mostrar
    - Guarda los datos, ahora aparecerá un nuevo boton, al darle clic aparecerá el sidebar. 
    - Si quiere ocultar el otro menu, deshabilite el elemento #2. 
- Le cambie el nombre al archivo portabilidad.php por normalize-web.php
- Uni los tres archivos de las funciones de template en uno solo (view.php, scripts.php, comandos.php).
- Ahora los textos de los iframe de las versiones en linea se muestran con los colores correspondientes.
- Solucione el error donde no se mostraban los iconos de me gusta y no me gusta en los comentarios.
- En los creadores los botones de refrescar y mostrar ahora muestran los iconos.

### Dashboard
- Menú de entradas:
    - Elimine la entrada de actualizar (solo era un enlace externo).

- Apartados modificados:
    - Configuración: Quite la api, y ahora funciona bien la selección de color predeterminado.
    - Información: Ordene un poco el contenido.
    - Scripts:
        - Quite el código que usaba para los iconos de Font Awesome, ahora se usara el cdn versión 5.15.4.
        - Ahora los scripts ingresados se guardan en config.json.

### Eliminados

Ahora las plantillas tienen el html y muestran lo necesario.

- up-view.php (Boton volver arriba)
- acciones-view.php (Input checkbox para mostrar el sidebar)
- header-view.php (Mostrar anuncios)
- bienvenida.php|bienvenida.json (Ahora el index muestra lo necesario)
- api.php|api.json
- admin-list-view.php (Ahora las entradas estan en admin.json)
- rules.json (Ahora los datos estan en admin.json)
- adaptabilidad.php (Los codigos ahora estan en normalize-web.php)

## [0.3.6 Stable] - 24/10/2025
Formato Markdown para las publicaciones y selector de color predeterminado

- Ahora se puede usar el formato Markdown en las publicaciones normales.

Utilice [PHP Markdown Lib](https://github.com/michelf/php-markdown)
(c) 2004–2022 Michel Fortin — Licencia BSD (basada en Markdown por John Gruber).

- Solucione un bug en el selector de idioma por defecto en la configuración del panel.
- Agregue un selector del color del tema por defecto en la configuración del panel.

## [0.3.5 Stable] - 23/10/2025
Selección de tema (daamper) y optimización

- Optimice el codigo de las paginas (normal, blog).
- Moví todo el código de la vista **head & template** hacia la vista **layout** y elimine la vistas.
- Cambie el código del sistema de temas y ahora se puede seleccionar el tema desde la configuración (admin).
    - El tema que sigue por defecto es daamper.
    - Ahora los temas se sacan directamente del archivo css del tema.
- Elimine bastantes archivos del tema que estaban separados y los junte en un solo archivo.
- En el perfil ya no se muestra el rol.

Un pequeño paso para la versión 0.4.0 🙂

## [0.3.4 Stable] - 07/08/2025
Reestructuración interna y limpieza de controladores:

- Se eliminaron los archivos `recursos.php` y `system.php`.
- El contenido fue migrado y unificado en la clase estática `Daamper` ubicada en [daamper](./app/controller/daamper.php).
- Las funciones de recursos fueron reemplazadas por sus equivalentes en las nuevas ubicaciones.
- Se eliminaron las referencias a recursos y system en [controller](./app/controller/controller.php).
- Ajustes y refactorización en más de 20 archivos para adaptarse a la nueva estructura.

## [0.3.3 Stable] - 06/08/2025
Reestructuración interna para mejorar la arquitectura del sistema:

- Se eliminó el uso incorrecto de `define()` con objetos (lo cual no es permitido en PHP 8.2+).
- Se creó la clase estática `Daamper` para almacenar datos de configuración global del sistema:
  - `$info`, `$version`, `$language`, `$config`, `$infoversion`, `$projectInfo`, `$scripts`, `$data`, `$sendAlert`.
- Se instancian ahora con `Daamper::$info` en lugar de constantes como `INFO`, `VERSION`, `LANGUAGE`, etc.
- Se creó la clase `ProjectInfo` para encapsular y organizar los datos del proyecto.
- Se actualizaron más de 80 archivos para adaptarlos a la nueva estructura.
- Mejora de seguridad, mantenibilidad y compatibilidad con versiones modernas de PHP.
- Se solucionaron advertencias `Deprecated` relacionadas con el orden de parámetros opcionales en funciones para compatibilidad con PHP 8.0+.


## [0.3.2 Stable] - 25/07/2025
- Reemplazo de define() con objeto por variable global segura ($WEBSITE)

- Se eliminó el uso incorrecto de define("WEBSITE", new Web()) que causaba un TypeError en PHP 8.2, ya que define() no acepta objetos como segundo parámetro.

- Ahora se usa una variable global $WEBSITE inicializada en el sistema principal, lo que garantiza compatibilidad con versiones modernas de PHP y mantiene la accesibilidad en todo el proyecto.

Este cambio también permite evitar errores de tipo y mejorar la mantenibilidad del código.


## [0.3.1.1 Stable] - 14/06/2025
Corregido bug en recuperación de cuenta

-   Corregido problema donde no se cambiaba la contraseña y no se mostraba la alerta de recomendación.
-   Solucionado bucle que pedía cambiar la contraseña incluso después de haberla cambiado correctamente.
-   Actualizado versión y cambios.
-   Corregido la fecha de la versión `0.3.1` en **CHANGELOD.md**

Archivo corregido: [`auth`](./app/actions/public/auth.php)

## [0.3.1 Stable] - 13/06/2025
-   Se agrego nuevo contenido e instrucciones para cambiar el idioma, iniciar sesión, hacer la primera publicación, configurar la pagina, configurar la plantilla y se cambiaron los comandos en la publicación [`bienvenida`](./database/post/bienvenida.json).
-   Se agrego un componente para mostrar los [`comandos`](./app/views/components/commands-view.php) en los apartados de los creadores [`normal`](./app/views/admin/creators/normal-view.php), [`anime entrada`](./app/views/admin/creators/anime_entrada-view.php) y [`juego`](./app/views/admin/creators/juego-view.php).
-   Se cambio el nombre del archivo de los `comandos.php` por [`commands.php`](./app/scripts/commands.php), se mejoro el sistema para los nuevos comandos, compatibilidad para los antiguos, soporte extendido para botones, enlaces, íconos, entre otros. Además se usa un archivo json para los [`comandos`](./database/config/commands.json).
-   Se removió la función de **PlantillaComandos** para evitar futuros problemas y vulnerabilidades en vista [`normal`](./app/views/main/normal-view.php)
-   Se agregaron los comandos para que puedan ser usados en la sinopsis de los animes y juegos, además en los anuncios.
-   Se cambio el nombre de la función comandos por Commands y se actualizo el contenido de la función en los [`scripts`](./app/scripts/scripts.php).
-   Se cambiaron los comandos de la plantilla por los comandos de las publicaciones en el `index`.
-   Se corrigieron los enlaces de subir imágenes.
-   Nuevos estilos para los campos de texto, color de texto de comandos y un flex center en los estilos [`global`](./assets/css/global.css).
-   Ahora los anuncios funcionan con los comandos de las publicaciones.
-   Se agrego un nuevo archivo para los [`comandos`](./database/config/commands.json).
-   Los comandos ahora se mostraran en la api.
-   Se agregaron los comandos de cmd (version y state) para no tener que actualizar los anuncios en movimiento cada ves que llegue una nueva actualización.
-   Nuevas traducciones, se actualizaron las versiones y los cambios.

### Correcciones
-   Corrección de espaciado cuando no se coloca el fragmento en las publicaciones de tipo blog.
-   Corrección de importación de fuentes Poppins.
-   Corrección en los enlaces de subir imagen en los creadores y anuncios.
-   `30/05/2025` Corrección de etiquetas mal escritas en las traducciones para los géneros de los animes.

## [0.3.0 Stable] – 27/05/2025
-   Generador de pin y recuperación de cuenta.
-   En la configuración del perfil se agregó una vista para mostrar u generar un nuevo pin.
-   Cuando una persona se registre automáticamente se creará un pin, se iniciará sesión y lo mandara al perfil.
-   Antes de cerrar sesión se mostrará una alerta para guardar el pin de recuperación.
-   Se reestructuro el archivo procesa de auth.
-   Se movieron todos los archivos del creador y se actualizaron todos los datos.
-   Nuevas traducciones y versiones.
-   Se agregaron nuevos scripts y funciones.
-   La mayoría de archivos que estaban enfocados en guardar datos fueron movidos a `./database/`
-   Todos los archivos de tipo **procesa** fueron movidos a `./app/actions/`
-   El panel administrativo fue unido al sistema y se distribuyó en múltiples secciones.
-   Las entradas "oficiales" se les cambiaron los nombres por inglés.
    -   `auth/`, `process/`, `admin/`, `report`
-   Las entradas normales cuando tengan como título `undefined` y se encuentren en el archivo [default](./database/creator/default.json), sección `titles` entonces van a poder agregarlos en múltiples idiomas desde el archivo [Language](./database/config/language.json) desde la sección `posts`, según la ruta de la publicación.
-   Se quito la vista de actualizar rol del apartado **auth/config**.
-   Se amplio el tamaño maximo de 1mb a 5mb en la subida de imágenes del panel administrativo.
-   Se creo un archivo [default](./database/config/default.json) que contiene la red social y enlace que aparecerá por defecto en los perfiles.
-   Casi todos los apartados del panel fueron actualizados.
-   En la sección info del panel se unió el nombre del creador y la pagina en uno solo, además como proyecto se agregó daamper.
-   Los borradores y posts están en `./database/`
-   En el apartado usuarios del panel se cambiaron los campos por textos, y se dejó solo como opcion para modificar el rol y el estado del usuario.
-   Cada usuario con un rol superior a **usuario** va a poder acceder a algunas secciones del panel.
-   Los usuarios de tipo **Administrador** pueden agregar, quitar roles de editor, además de eliminar usuarios.
-   Los usuarios de tipo **CEO Founder** tienen acceso a todo y pueden añadir más CEO Founder.
-   Los apartados ahora guardan los datos en archivos json.
-   Cuando cambien el avatar automáticamente los mandara al perfil.
-   Los dos procesa de imágenes fueron unido en uno solo con un componente [uploade-image](./app/actions/components/upload-image.php)
-   Se movio el avatar_default.png de img/avatar/ a [img/avatar-profile.png](./assets/img/avatar-profile.png)
-   Antes el apartado plantilla tenía un procesa, pero ahora se usará el mismo de los otros apartados → [actions](./admin/process/actions.php).
-   El sistema de comentarios funciona con la nueva base de datos y tiene verificación de comentarios para evitar spam.
-   Se agrego una nueva función para las sumas y desde el archivo [default](./database/config/default.json) puede ser modificado el mínimo, máximo, además la mínima y máxima cantidad en los inputs.
-   Los estilos que estaban en la view de blog fueron movidos a [global.css](./assets/css/global.css).
-   Ahora cuando se reaccione desde el panel, los mandara al panel.
-   Todos los comentarios y respuestas se mostrarán en orden, y ya no dentro de otro comentario en el panel.
-   Ya no se puede comentar en el panel, pero si responder.
-   Los datos para filtrar los comentarios se quedan con los datos que agregaron.
-   Se agrego un formulario para cambiar el estado del comentario en el panel.
-   Se mostrarán todas las respuestas de comentarios.
-   Se hicieron correcciones a los estilos.
-   Opciones para eliminar u publicar de nuevo los comentarios en el panel.
-   Se agregaron más contenido al apartado información del panel y se hicieron más traducciones.
-   Se elimino la función AppDatabase().
-   Ahora desde el apartado creador algunos directorios serán denegados y también algunos archivos solo pueden ser editados, modificados u eliminados con ciertos roles.
-   Ahora los datos de ads, scripts y htaccess estaran en el mismo archivo [config.json](./database/config/config.json).
-   Se cambio la función `mensajeSpan()` por la clase `sendAlert` que contiene:
    -   Success → Éxito
    -   Error   → Error
    -   Warning → Advertencia
    -   Info    → Información
    -   Refresh → Refrescar *(Creator)*
-   Los iconos que estaban redondeados en el footer, ahora tendrán un redondeo menor y un padding más normalizado.
-   Ahora se puede cambiar, mostrar y ocultar los anuncios en la entrada de anime mirando, desde el archivo [default.json](./database/config/default.json) sección `entries\anime_mirando`
-   Se puedes agregar más géneros, categorías, consolas, motores..., desde el archivo [list-tags.json](./database/creator/list-tags.json).
-   Se dividió los motores de los géneros y ahora son independiente para las entradas juego.
-   Se movieron los directorios assets/css/ → `components`, `theme` a `template/daamper/`, de esta forma se van a poder agregar más estilos de plantillas.
-   Se agrego el apartado `/api` en el que aparecerá casi todos los datos de la página y esta puede mostrarse, ocultarse y de demás cosas desde el apartado `Config` del panel.
-   Ya no se abrirán nuevas pestañas cuando se toque una entrada en el buscador.
-   Se actualizaron algunos estilos.
-   Ahora desde el apartado directorio se mostrará primeros los directorios y después los archivos.
-   Ahora se mostrarán las imágenes desde el apartado directorio y editor.
-   Desde el apartado editor se puede mostrar una imagen y además eliminarla.
-   Ahora cuando un comentario este en revisión o sea eliminado, se mostrará de otro color en el apartado comentarios del panel.

### Correcciones
-   Se soluciono la verificación de contraseña a la hora de subir un avatar.
-   Se soluciono el problema de cuando se subía una imagen y se quitaba parte del nombre.
-   Se soluciono un bug que mostraba el sistema de comentarios en el apartado `creator|preview`.
-   Se soluciono los errores que aparecían cuando se buscaba en el buscador.
-   Se soluciono el espaciado de texto dentro de las card de las entradas y el tamaño del texto esta por default.
-   Ahora se muestra el título de la opción del stream en la entrada anime mirando.
-   Ahora los géneros en las entradas de juego se muestran en los diferentes idiomas.

## [0.2.7 Stable] – 16/04/2025
Corregido el reinicio de listas de entradas y añadido enlace para recargar el formulario.

## [0.2.6.1 Stable] – 02/04/2025
Se agrego un sistema de busquedas el cual permitira buscar los posts mas rapido.

### Añadidos
- Se agrego un componente llamado [search](./app/views/components/search-view.php).
- Se agrego una vista llamada [search](./app/views/main/search-view.php).
- Se agrego la nueva entrada [search](./search.php).
- Se agrego los datos del search en la database [search](./database/other/search.json).
- Se agrego los titulos con traducciones para el search en [mod](./panel/app/creador/creadores/normal/mod.php).
- Se actualizaron las versiones e idioma.

### ⚠️ ¡importante!
- Puede que no funcione para las publicaciones de ver animes.

## [0.2.6 Stable] – 30/03/2025
Nuevas traducciones, optimizaciones y correcciones para el sitio web.

### Mejoras
- Se agregaron las traducciones y se optimizo el código de la vista [perfil](./app/views/main/perfil-view.php).
- Se agregaron algunas traducciones al archivo [language](./database/config/language.json).
- Se agrego las traducciones a las vistas
    - [form-comentar](./app/views/main/form-comentar-view.php) | [comentarios](./app/views/main/comentarios-view.php) | [comentario](./app/views/main/comentario-view.php) | [reportar](./app/views/main/reportar-view.php).
- Se quito el apartado editor de la lista del panel, ya que este solo se puede usar con un archivo desde el **directorio** [panel-lista](./app/views/main/panel-lista-view.php).

- Se agrego las traducciones a los archivos procesas
    - [comentar](./procesa/procesa.comentar.php) | [reaccionar](./procesa/procesa.reaccionar.php) | [reportar](./procesa/procesa.reportar.php) | [creador.borrador](./panel/procesa/procesa.creador.borrador.php)

### Actualizados
- Se cambio la referencia de **version.txt** a [CHANGELOG](./CHANGELOG.md) y se agregó el enlace para descargar el código desde [dbproject](https://dbproject.rf.gd/web/daamper) en [README](./README.md).
- Se cambiaron las versiones y las fechas de system y language del archivo [version](./database/config/version.json), además se agregó la versión **other/form-comment**.
- Se quito el contenido desplegable de la versión de los datos del archivo [bienvenida](./app/database/publicaciones/pu_bienvenida.php).

### Correcciones
- Cualquier persona podia entrar a auth/configuracion sin necesidad de haber iniciado sesión, se corrigió [auth](./app/global/routes/auth.php).
- Se corrigió un bug al cargar la vista del comentario en el archivo [reportar](./app/views/main/reportar-view.php).

### Agregados
- Se agrego el archivo [CHANGELOG](./CHANGELOG.md) para mostrar las nuevas novedades de la página.

### Eliminados
- Se elimino el archivo **./version.txt**, ahora se usará [CHANGELOG](./CHANGELOG.md).