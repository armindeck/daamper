<?php // daamper settings
class Daamper{
    public static array $info;
    public static array $version;
    public static array $language;
    public static array $config;
    public static array $infoversion;
    public static $projectInfo;
    public static $scripts;
    public static $data;
    public static $sendAlert;

    public static function init(): void{
        self::$info = self::loadData('config/info');
        self::$version = self::loadData('config/version');
        self::$language = self::loadData('config/language');
        self::$config = self::loadData('config/config')["config"];
        self::$infoversion = array_merge(self::$info, self::$version['system']);
        self::$projectInfo = new ProjectInfo();
    }
    
    // Paths
    public static function globalPath(string $file = "global"): string { return "app/global/{$file}.php"; }
    public static function contentPath(string $file = "content"): string { return "app/content/{$file}.php"; }
    public static function viewsPath(string $file = "layout"): string { return "app/views/{$file}-view.php"; }
    public static function cssPath(string $file = "styles"): string { return "assets/css/{$file}.css"; }
    public static function imgPath(string $file = ""): string { return "assets/img/{$file}"; }
    
    // Functions
    public static function loadData(string $route, string $otherRoute = ""){ global $Web;
        $route = $Web['directorio'] . "database/{$route}".(!empty($otherRoute) ? "/{$otherRoute}" : '').'.json';
        return !file_exists($route) ? [] : json_decode(file_get_contents($route), true);
    }
    
    public static function views(string $file = 'main', ...$Var) { global $Web;
        $file = $Web['directorio'] . self::viewsPath($file);
        if (!file_exists($file)) { die("El archivo {$file}, no existe!"); }
        require $file;
    }

    public static function view(string $file, array $data = []) : void {
        global $Web;
        $file = $Web['directorio'] . self::viewsPath($file);
        if (!file_exists($file)) { die("El archivo {$file}, no existe!"); }
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }
        require $file;
    }
}

# Project info
class ProjectInfo {
    public string $nombre;
    public string $enlace;
    public string $creador;
    public string $creador_nombre_web;
    public string $creador_enlace;
    public int $anio;
    public string $version;
    public string $estado;
    public string $version_estado;
    public string $creada;
    public string $mod;
    public array $redes;

    public function __construct() {
        $this->nombre = Daamper::$info['page-name'] ?? 'Nombre no disponible';
        $this->enlace = Daamper::$info['page-url'] ?? '#';
        $this->creador = Daamper::$info['author'] ?? 'Desconocido';
        $this->creador_nombre_web = Daamper::$info['author-page-name'] ?? 'No disponible';
        $this->creador_enlace = Daamper::$info['author-page-url'] ?? '#';
        $this->anio = Daamper::$info['anio'] ?? 2024;
        $this->version = Daamper::$version['system']['version'] ?? '0.0.0';
        $this->estado = Daamper::$version['system']['state'] ?? 'Desconocido';
        $this->version_estado = "v" . $this->version . " " . $this->estado;
        $this->creada = Daamper::$version['system']['created'] ?? 'No disponible';
        $this->mod = Daamper::$version['system']['updated'] ?? 'No disponible';
        $this->redes = Daamper::$info['social-networks'] ?? [];
    }

    public function social_networks(): array {
        return $this->redes;
    }

    public function render(): string {
        return '<span style="font-size: 14px;">'.
            Language("copy", "system", ["author" => "<a target=\"_blank\" href=\"".$this->creador_enlace."\">".$this->creador."</a>", "system-name" => "<a target=\"_blank\" href=\"".$this->enlace."\">".$this->nombre."</a>", "version" => $this->version, "state" => (Language(strtolower($this->estado == "Estable" ? "stable" : $this->estado))), "updated" => $this->mod]). '<br>'.Language("license", "system")
            .'</span>';
    }
}

const RAIZ = __DIR__ . "/../../";
Daamper::init();