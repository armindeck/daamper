<!-- © 2024 Armin | dbproject.rf.gd -->
<!DOCTYPE html>
<html lang="<?= Daamper::$config['language'] ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once $Web['directorio'] . AppViews("head") ?>
</head>
<body>
	<?= Views("template") ?>
	<?php unset($_SESSION["sendAlert"]); ?>
</body>
</html>