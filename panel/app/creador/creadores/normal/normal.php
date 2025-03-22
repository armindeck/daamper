<?=
pTextarea(['name' => 'fragmento', 'placeholder' => (LANGUAJE['global']['fragment'][CONFIG['languaje']]), 'label' => false, 'texto' => (LANGUAJE['global']['fragment'][CONFIG['languaje']]), 'style' => 'min-height:50px']) .
	pTextarea(['name' => 'contenido', 'placeholder' => (LANGUAJE['global']['content'][CONFIG['languaje']]), 'label' => false, 'texto' => (LANGUAJE['global']['content'][CONFIG['languaje']]), 'style' => 'min-height:250px']) .
	pSelect(['name' => 'tipo', 'texto' => (LANGUAJE['global']['type'][CONFIG['languaje']]), 'option' => [
		'normal' => (LANGUAJE['global']['normal'][CONFIG['languaje']]),
		'blog' => (LANGUAJE['global']['blog'][CONFIG['languaje']]),
		'normal-blog' => (LANGUAJE['dashboard']['creador']['blog-and-thumbnail'][CONFIG['languaje']]),
		'libre' => (LANGUAJE['global']['free'][CONFIG['languaje']]),
	]])
?>
<?php if (isset($_SESSION['tmpForm']["archivo"]) && $_SESSION['tmpForm']["archivo"] == 'index.php') : ?>
	<details>
		<summary><?= (LANGUAJE['dashboard']['creador']['list-of-entries'][CONFIG['languaje']]) ?></summary>
		<section>
			<?php $p = file_exists(__DIR__ . '/function/lista-publicaciones.php') ? require __DIR__ . '/function/lista-publicaciones.php' : [];
			$j = 1;
			foreach ($p as $key => $value) {
				echo '<section class="flex-column"><label class="flex-between"><span>' . ($value['entrada'] ? ucfirst($value['entrada']) : (LANGUAJE['dashboard']['creador']['posts'][CONFIG['languaje']])) . '</span><section class="flex-between">';
				echo pInput(['type' => 'number', 'class' => 'form-campo-pequeno', 'title' => (LANGUAJE['global']['position'][CONFIG['languaje']]), 'name' => "posicion-{$value['entrada']}", 'value' => $j, 'placeholder' => $j]);
				echo pCheckboxBoton(['name' => "mostrar-{$value['entrada']}", 'id' => "mostrar-{$value['entrada']}", 'icono' => 'fas fa-eye']);
				echo '</section></label></section>';
				$j++;
			} ?>
		</section>
	</details>
<?php endif; ?>