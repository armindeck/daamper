<?php echo
	pTextarea(['name' => 'fragmento', 'placeholder' => Language('fragment'), 'label' => false, 'texto' => Language('fragment'), 'style' => 'min-height:50px']);
	Views("components/commands");
	echo 
	pTextarea(['name' => 'contenido', 'placeholder' => Language('content'), 'label' => false, 'texto' => Language('content'), 'style' => 'min-height:250px']) .
	pSelect(['name' => 'tipo', 'texto' => Language('type'), 'option' => [
		'normal' => Language('normal'),
		'blog' => Language('blog'),
		'normal-blog' => Language(['creator', 'blog-and-thumbnail'], 'dashboard'),
		'libre' => Language('free'),
	]])
?>
<?php if (isset($_SESSION['tmpForm']["archivo"]) && $_SESSION['tmpForm']["archivo"] == 'index.php') : ?>
	<details>
		<summary><?= Language(['creator', 'list-of-entries'], 'dashboard') ?></summary>
		<section>
			<?php $p = file_exists(RAIZ . "database/creator/list-of-entries.json") ? Daamper::$data->Read("creator/list-of-entries") : [];
			$j = 1;
			foreach ($p as $key => $value) {
				echo '<section class="flex-column"><label class="flex-between"><span>' . ($value['entrada'] ? ucfirst($value['entrada']) : Language(['creator', 'posts'], 'dashboard')) . '</span><section class="flex-between">';
				echo pInput(['type' => 'number', 'class' => 'form-campo-pequeno', 'title' => Language('position'), 'name' => "posicion-{$value['entrada']}", 'value' => $j, 'placeholder' => $j]);
				echo pCheckboxBoton(['name' => "mostrar-{$value['entrada']}", 'id' => "mostrar-{$value['entrada']}", 'icono' => 'fas fa-eye']);
				echo '</section></label></section>';
				$j++;
			} ?>
		</section>
	</details>
<?php endif; ?>