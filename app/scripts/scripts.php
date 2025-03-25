<?php
class scripts{
    public function zona(){ date_default_timezone_set('America/Bogota'); }
    public function fecha(){ $this->zona(); return date('d/m/Y'); }
    public function fecha_hora(){ $this->zona(); return date('d/m/Y - g:ia'); }
    public function anio(){ $this->zona(); return date('Y'); }
    public function normalizar($valor){
        $valor = $this->convertirSimbolos($valor);
        //$valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripcslashes($valor);
        return $valor;
    }
    public function normalizar2($valor){
        $valor = htmlspecialchars($valor);
        $valor = trim($valor);
        $valor = stripcslashes($valor);
        return $valor;
    }
    public function convertirSimbolos($valor) {
        $valor = str_replace('<', '&lt;', $valor);
        $valor = str_replace('>', '&gt;', $valor);
        $valor = str_replace('"', '&quot;', $valor);
        $valor = str_replace("'", '&#039;', $valor);
        $valor = str_replace('{', '&#123;', $valor);
        $valor = str_replace('}', '&#125;', $valor);
        return $valor;
    }
    public function quitarComilla($valor){
        return $valor = str_replace("'", '&#039;', $valor);
    }
    public function sinEPHP($valor){
        return $valor = str_replace(".php", '', $valor);
    }
    public function eslasToGuion($valor){
        return str_replace('/', '-', $valor);
    }
    public function darFormatoNoSimbolos($string) {
        $string = str_replace(array('☺', '☻', '♥', '♦', '♣', '♠', '•', '◘', '○', '◙', '♂', '♀', '♪', '♫', '☼', '►', '◄', '↕', '‼', '¶', '§', '▬', '↨', '↑', '↓', '→', '←', '∟', '↔', '▲', '▼', '!', '"', '#', '$', '%', '&', '(', ')', '*', '+', ',', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '`', '{', '|', '}', '~', '⌂', 'ª', 'º', '¿', '®', '¬', '½', '¼', '¡', '«', '»', '░', '▒', '▓', '│', '┤', '©', '╣', '║', '╗', '╝', '¢', '¥', '┐', '└', '‼', '┴', '┬', '├', '─', '┼', '╚', '╔', '╩', '╦', '╠', '═', '╬', '¤', 'ð', '┘', '┌', '█', '▄', '¦', '▀', '¯', '´', '±', '³', '²', '¶', '§', '÷', '¸', '°', '¨', '·', '¹', '³', '²', '■', "'", '“', '”','-','/'), '', $string );
        return $string;
        #SOLO PASA  GUION BAJO "_", '.'
    }
    public function darFormatoNoSimbolosRuta($string) {
        $string = str_replace(array('☺', '☻', '♥', '♦', '♣', '♠', '•', '◘', '○', '◙', '♂', '♀', '♪', '♫', '☼', '►', '◄', '↕', '‼', '¶', '§', '▬', '↨', '↑', '↓', '→', '←', '∟', '↔', '▲', '▼', '!', '"', '#', '$', '%', '&', '(', ')', '*', '+', ',', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '`', '{', '|', '}', '~', '⌂', 'ª', 'º', '¿', '®', '¬', '½', '¼', '¡', '«', '»', '░', '▒', '▓', '│', '┤', '©', '╣', '║', '╗', '╝', '¢', '¥', '┐', '└', '‼', '┴', '┬', '├', '─', '┼', '╚', '╔', '╩', '╦', '╠', '═', '╬', '¤', 'ð', '┘', '┌', '█', '▄', '¦', '▀', '¯', '´', '±', '³', '²', '¶', '§', '÷', '¸', '°', '¨', '·', '¹', '³', '²', '■', "'", '“', '”','.'), '', $string );
        return $string;
        #SOLO PASA  GUION BAJO "_", '-', '/'
    }
    public function sinEspacios($string){
        $string = str_replace(' ', '-', $string);
        return $string;
    }
    public function sinAcentos($string){
        $string = str_replace('á','a',$string);
        $string = str_replace('Á','A',$string);
        $string = str_replace('é','e',$string);
        $string = str_replace('É','E',$string);
        $string = str_replace('í','i',$string);
        $string = str_replace('Í','I',$string);
        $string = str_replace('ó','o',$string);
        $string = str_replace('Ó','O',$string);
        $string = str_replace('ú','u',$string);
        $string = str_replace('Ú','U',$string);
        return $string;
    }
    public function sinEnes($string){
        $string = str_replace('ñ','n',$string);
        $string = str_replace('Ñ','N',$string);
        return $string;
    }
    public function quitarEPHP($string){
        return str_replace('.php', '', $string);
    }
    public function quitarPuntoEslas($string){
        $string = str_replace('../', '', $string);
        return str_replace('./', '', $string);
    }
    public function xv(string $apartado, string $other = null, string $simple = null){
        $return = '';
        foreach (['version', 'state', 'updated'] as $value) {
            if (empty($other)) {
                $return .= VERSION['dashboard'][$apartado][$value] . ' ';
            } else {
                $return .= VERSION['dashboard'][$apartado]['other'][$value] . ' ';
            }
        }
        
        /*
        foreach ($XVERSION as $key => $value) {
            $leer .= file_get_contents((is_string($ubi) ? $ubi : $ubi[0]).'/x/'.$value.'.x').' ';
        }
        */
        
        if($simple === null){
            return '<p class="t-12">v'.$return.'</p>';
        }
        return $return;
    }
    public function RutaConvertir ($string) {
        $string = trim($string);
        $string = $this->sinEspacios($string);
        $string = $this->darFormatoNoSimbolosRuta($string);
        $string = $this->sinEnes($string);
        $string = $this->sinAcentos($string);
        $string = strtolower($string);
        return $string;
    }
    public function archivoAceptado($string){
        $method = '-_--pu_nto--_-';
        $string = str_replace('.', $method, $string);
        $string = $this->eslasToGuion($string);
        $string = $this->RutaConvertir($string);
        return str_replace($method, '.', $string);
    }
    public function rutaAceptada($string){
        return $this->RutaConvertir($string);
    }
    public function comandos($Web, $string){
        require_once __DIR__.'/comandos.php';
        return $string;
    }
    public function saltoToBr ($string) {
        # REEMPLAZAR EL \N POR <BR>
        $string = preg_replace('/(\n{3,})/', "\n\n", $string);
        $string = str_replace("\n", "<br>", $string);
        $string = str_replace("<br>[/n]", '', $string);
        return $string;
    }
    public function espacios_left ($string) {
        return str_replace("  ", '<i style="margin-left: 8px;"></i>', $string);
    }
    public function fechasInputDate(string $string) {
        $convertir = explode("-", $string);
        $convertir_texto = match (true) {
            $convertir[1] == "01" => 'Enero',
            $convertir[1] == "02" => 'Febrero',
            $convertir[1] == "03" => 'Marzo',
            $convertir[1] == "04" => 'Abril',
            $convertir[1] == "05" => 'Mayo',
            $convertir[1] == "06" => 'Junio',
            $convertir[1] == "07" => 'Julio',
            $convertir[1] == "08" => 'Agosto',
            $convertir[1] == "09" => 'Septiembre',
            $convertir[1] == "10" => 'Octubre',
            $convertir[1] == "11" => 'Noviembre',
            $convertir[1] == "12" => 'Diciembre',
            default => 'indefinido',
        };
        if (substr($convertir[2], 0, 1) == 0) {
            $convertir[2] = substr($convertir[2], 1, strlen($convertir[2]));
        }
        return "{$convertir[2]} de {$convertir_texto} del {$convertir[0]}";
    }
}
define('SCRIPTS', $SCRIPTS = new scripts);

foreach (
    [
        'mensaje-span.scr',
        'input',
        'plantilla/view',
        'function'
    ] as $key => $value) {
    require_once __DIR__ . "/$value.php";
}
?>