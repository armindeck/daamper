# Changelog
Descubre las nuevas novedades de daamper!

## 02/04/2025
Se agrego un sistema de busquedas el cual permitira buscar los posts mas rapido.

## Añadidos
- Se agrego un componente llamado [search](./app/views/components/search-view.php).
- Se agrego una vista llamada [search](./app/views/main/search-view.php).
- Se agrego la nueva entrada [search](./search.php).
- Se agrego los datos del search en la database [search](./database/other/search.json).
- Se agrego los titulos con traducciones para el search en [mod](./panel/app/creador/creadores/normal/mod.php).
- Se actualizaron las versiones e idioma.

## ⚠️ ¡importante!
- Puede que no funcione para las publicaciones de ver animes.

## 30/03/2025  
Nuevas traducciones, optimizaciones y correcciones para el sitio web.

## Mejoras
- Se agregaron las traducciones y se optimizo el código de la vista [perfil](./app/views/main/perfil-view.php).
- Se agregaron algunas traducciones al archivo [language](./database/config/language.json).
- Se agrego las traducciones a las vistas
    - [form-comentar](./app/views/main/form-comentar-view.php) | [comentarios](./app/views/main/comentarios-view.php) | [comentario](./app/views/main/comentario-view.php) | [reportar](./app/views/main/reportar-view.php).
- Se quito el apartado editor de la lista del panel, ya que este solo se puede usar con un archivo desde el **directorio** [panel-lista](./app/views/main/panel-lista-view.php).

- Se agrego las traducciones a los archivos procesas
    - [comentar](./procesa/procesa.comentar.php) | [reaccionar](./procesa/procesa.reaccionar.php) | [reportar](./procesa/procesa.reportar.php) | [creador.borrador](./panel/procesa/procesa.creador.borrador.php)

## Actualizados
- Se cambio la referencia de **version.txt** a [CHANGELOG](./CHANGELOG.md) y se agregó el enlace para descargar el código desde [dbproject](https://dbproject.rf.gd/web/daamper) en [README](./README.md).
- Se cambiaron las versiones y las fechas de system y language del archivo [version](./database/config/version.json), además se agregó la versión **other/form-comment**.
- Se quito el contenido desplegable de la versión de los datos del archivo [bienvenida](./app/database/publicaciones/pu_bienvenida.php).

## Correcciones
- Cualquier persona podia entrar a auth/configuracion sin necesidad de haber iniciado sesión, se corrigió [auth](./app/global/routes/auth.php).
- Se corrigió un bug al cargar la vista del comentario en el archivo [reportar](./app/views/main/reportar-view.php).

## Agregados
- Se agrego el archivo [CHANGELOG](./CHANGELOG.md) para mostrar las nuevas novedades de la página.

## Eliminados
- Se elimino el archivo **./version.txt**, ahora se usará [CHANGELOG](./CHANGELOG.md).