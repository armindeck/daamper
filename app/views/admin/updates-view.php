<?php
$content = "<a class=\"boton-2\" href=\"" . Daamper::$info['author-page-url'] . "\" class=\"t-small\" target=\"_blank\">" . (Language(['updates', 'text'], 'dashboard')) . " <i class=\"fas fa-external-link-alt\"></i></a>";
$content .= "<hr>";
$content .= "<iframe frameborder=\"0\" width=\"100%\" style=\"min-height: 400px;\" src=\"" . Daamper::$info['author-page-url'] . "/main_external.php?tema=" .
	($_SESSION['tmp']['color'] ?? $Web["config"]["color"] ?? 'light') . "&cantidad=5&background=none&contenido=daamper-actualizaciones-resumen&font-size=14px\"></iframe>";

echo $render->dropdown([
	"id" => "updates-container",
	"title" => "updates",
	"checked" => true,
	"content" => "<nav class=\"flex flex-column\">". ($content ?? "") ."</nav>"
]); ?>
