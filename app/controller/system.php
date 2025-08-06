<?php # Project info
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
}

Daamper::$info = Database('config/info');
Daamper::$version = Database('config/version');
Daamper::$language = Database('config/language');
Daamper::$config = Database('config/config')["config"];
Daamper::$infoversion = array_merge(Daamper::$info, Daamper::$version['system']);

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

    public function redes_sociales(): array {
        return $this->redes;
    }

    public function render(): string {
        return '<span style="font-size: 14px;">'.
            Language("copy", "system", ["author" => "<a target=\"_blank\" href=\"".$this->creador_enlace."\">".$this->creador."</a>", "system-name" => "<a target=\"_blank\" href=\"".$this->enlace."\">".$this->nombre."</a>", "version" => $this->version, "state" => (Language(strtolower($this->estado == "Estable" ? "stable" : $this->estado))), "updated" => $this->mod]). '<br>'.Language("license", "system")
            .'</span>';
    }
}

Daamper::$projectInfo = new ProjectInfo();
const RAIZ = __DIR__ . "/../../";