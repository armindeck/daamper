<?php
$string = str_replace(['iframe{', 'iframe['], '<iframe width="800" height="450" src="', $string);
$string = str_replace(['}iframe;', ']/iframe'], '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>', $string);
$string = str_replace(['img{', 'img['], '<img loading="lazy" src="', $string);
$string = str_replace(['imgl{', 'imgl['], '<img loading="lazy" src="'. (isset($Web['config']['https_imagen']) ? $Web['config']['https_imagen'] : '').'assets/img/', $string);
$string = str_replace(['};', ']/;'], '">', $string);

foreach (
	[
		'b' => ['strong'],
		'details' => ['details', 'antes-despues' => '</section>'],
		'details-open' => ['details open', 'details', 'antes-despues' => '</section>'],
		'summary' => ['summary', 'despues' => '<section>'],
		'ul' => ['ul'],
		'section' => ['section'],
		'~' => ['i', 'antes-medio' => '~ ']
	]
	as $key => $value) {
	$string = str_replace(
		(is_string($key) ? (is_string($value) ? $key : "{$key}[") : "{$value}["),
		is_string($value) ? $value :
				($value['antes'] ?? '') .
				"<{$value[0]}>" .
				($value['antes-medio'] ?? ''),
		$string
	);
	if (!is_string($value)) {
		$string = str_replace("]/{$key}",
				($value['antes-despues'] ?? '').
				"</".($value[1] ?? $value[0]).">".
				($value['despues'] ?? ''),
				$string
		);
	}
}
for ($h = 1; $h <= 6; $h++) {
	$string = str_replace("h{$h}[", "<h{$h}>", $string);
	$string = str_replace("]/h{$h}", "</h{$h}>", $string);
}
?>