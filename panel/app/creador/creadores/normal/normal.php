<?=
pTextarea(['name' => 'fragmento', 'placeholder' => Language('fragment'), 'label' => false, 'texto' => Language('fragment'), 'style' => 'min-height:50px']) .
	pTextarea(['name' => 'contenido', 'placeholder' => Language('content'), 'label' => false, 'texto' => Language('content'), 'style' => 'min-height:250px']) .
	pSelect(['name' => 'tipo', 'texto' => Language('type'), 'option' => [
		'normal' => Language('normal'),
		'blog' => Language('blog'),
		'normal-blog' => Language(['creador', 'blog-and-thumbnail'], 'dashboard'),
		'libre' => Language('free'),
	]])
?>
<?php if (isset($_SESSION['tmpForm']["archivo"]) && $_SESSION['tmpForm']["archivo"] == 'index.php') : ?>
	<details>
		<summary><?= Language(['creador', 'list-of-entries'], 'dashboard') ?></summary>
		<section>
			<?php $p = file_exists(__DIR__ . '/function/lista-publicaciones.php') ? require __DIR__ . '/function/lista-publicaciones.php' : [];
			$j = 1;
			foreach ($p as $key => $value) {
				echo '<section class="flex-column"><label class="flex-between"><span>' . ($value['entrada'] ? ucfirst($value['entrada']) : Language(['creador', 'posts'], 'dashboard')) . '</span><section class="flex-between">';
				echo pInput(['type' => 'number', 'class' => 'form-campo-pequeno', 'title' => Language('position'), 'name' => "posicion-{$value['entrada']}", 'value' => $j, 'placeholder' => $j]);
				echo pCheckboxBoton(['name' => "mostrar-{$value['entrada']}", 'id' => "mostrar-{$value['entrada']}", 'icono' => 'fas fa-eye']);
				echo '</section></label></section>';
				$j++;
			} ?>
		</section>
	</details>
<?php endif; ?>