<div class="con t-center">
	<a href="<?= Daamper::$info['author-page-url'] ?>" target="_blank">
		<?= Language(['updates', 'text'], 'dashboard') ?>
		<i class="fas fa-external-link-alt"></i>
	</a>
</div>
<iframe frameborder="0" width="100%" style="min-height: 720px;"
	src="<?= Daamper::$info['author-page-url'].'/main_external.php'?>?tema=<?=
	($_SESSION['tmp']['color'] ?? $Web["config"]["color"] ?? 'light') ?>&cantidad=15&background=none&contenido=daamper-actualizaciones&font-size=14px"
></iframe>