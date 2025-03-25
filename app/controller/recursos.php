<?php
function AppScripts($valor=false){ return 'app/scripts/' . ($valor ? $valor : 'scripts') . '.php';  }
function AppHttp($valor=false){ return 'app/global/' . ($valor ? $valor : 'global') . '.php';  }
function AppContent($valor=false){ return 'app/content/' . ($valor ? $valor : 'content') . '.php';  }
function AppDatabase($valor=false){ return 'app/database/' . ($valor ? $valor : 'database') . '.php'; }
function AppViews($valor=false){ return 'app/views/' . ($valor ? $valor : 'layout') . '-view.php';  }

// Assets
function AssetsCss($valor=false){ return 'assets/css/' . ($valor ? $valor : 'estilo') . '.css';  }
function AssetsImg($valor){ return 'assets/img/' . ($valor ? $valor : '');  }


// Other
function Views(string $File = 'main', ...$Var) { global $Web;
    $File = $Web['directorio'] . "app/views/{$File}-view.php";
    if (file_exists($File)) { require $File; } else { die("El archivo {$File}, no existe!"); }
}

function Database(string $ruta, string $valor = null){ global $Web;
    $ruta = $Web['directorio']."database/$ruta".(!empty($valor) ? "/$valor" : '').'.json';
    return !file_exists($ruta) ? [] : json_decode(file_get_contents($ruta), true);
}