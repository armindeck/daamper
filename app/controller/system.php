<?php # SYSTEM
/* NO PUEDO USAR FOREACH PARA ORDENAR LOS DEFINE, YA QUE VS CODE DETECTA UN MONTON DE ERRORES :v */
define("INFO", Database('config/info'));
define("VERSION", Database('config/version'));
define("LANGUAJE", Database('config/languaje'));
define("CONFIG", Database('config/config'));
define("INFOVERSION", array_merge(INFO, VERSION['system']));

class Web {
    public $nombre;
    public $enlace;
    public $creador;
    public $creador_nombre_web;
    public $creador_enlace;
    public $anio;
    public $version;
    public $estado;
    public $version_estado;
    public $creada;
    public $mod;

    public function __construct() {
        $this->nombre = INFO['page-name'] ?? 'Nombre no disponible';
        $this->enlace = INFO['page-url'] ?? '#';
        $this->creador = INFO['author'] ?? 'Desconocido';
        $this->creador_nombre_web = INFO['author-page-name'] ?? 'No disponible';
        $this->creador_enlace = INFO['author-page-url'] ?? '#';
        $this->anio = '2024';
        $this->version = VERSION['system']['version'] ?? '0.0.0';
        $this->estado = VERSION['system']['state'] ?? 'Desconocido';
        $this->version_estado = "v" . $this->version . " " . $this->estado;
        $this->creada = VERSION['system']['created'] ?? 'No disponible';
        $this->mod = VERSION['system']['updated'] ?? 'No disponible';
    }

    public function redes_sociales() {
        return INFO['social-networks'] ?? [];
    }

    public function web() {
        return '<span style="font-size: 14px;">' .
            'Powered by <a target="_blank" href="' . $this->creador_enlace . '">' .
            $this->creador . '</a>: <a target="_blank" href="' . $this->enlace .
            '">' . $this->nombre . '</a> v' . $this->version . ' ' . $this->estado . ' ~ ' . $this->mod . '.<br>Licencia: Uso No Transferible.</span>';
    }
}
define("WEBSITE", new Web());