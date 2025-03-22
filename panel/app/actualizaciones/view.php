<div class="con t-center">
	<a href="<?= INFO['author-page-url'] ?>" target="_blank">
		<?= LANGUAJE['dashboard']['updates']['text'][CONFIG['languaje']] ?>
		<i class="fas fa-external-link-alt"></i>
	</a>
</div>
<iframe frameborder="0" width="100%" style="min-height: 720px;"
	src="<?=INFO['author-page-url'].'/main_external.php'?>?tema=<?=
	$_SESSION['tmp']['tema'] ?? 'blue-aero' ?>&cantidad=15&background=none&contenido=daamper-actualizaciones&font-size=14px"
></iframe>