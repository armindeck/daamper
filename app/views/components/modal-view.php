<input type="checkbox" class="check-modal" id="modal-<?= $id ?? "empty" ?>" hidden>
<div class="modal">
	<label for="modal-<?= $id ?? "empty" ?>" class="modal__header">
		<span class="icon"><i class="fas fa-chevron-circle-right"></i></span>
		<span><?= empty($escape_title) ? Language($title ?? "text") : ($title ?? "") ?></span>
	</label>
    <?php if(!empty($option) || !empty($content)): ?>
	<section class="modal__main">
        <nav>
            <header>
                <label for="modal-<?= $id ?? "empty" ?>" class="modal__header">
                    <span class="icon"><i class="fas fa-times"></i></span>
                    <span><?= Language("close") ?? "Cerrar" ?></span>
                </label>
            </header>
            <?php if(!empty($content)): ?>
                <section>
                    <?= is_callable($content) ? $content() : $content ?>
                </section>
            <?php endif; ?>
            <?php foreach ($option ?? [] as $value): ?>
            <label>
                <input type="checkbox" name="<?= $value["name"] ?? "" ?>" value="<?= $value["value"] ?? "" ?>" <?= !empty($value["checked"]) ? "checked" : "" ?> hidden>
                <span class="icon <?= !empty($value["title"]) ? "icon--left" : "" ?>">
                    <span class="inactive"><i class="<?= $button_right_icon_inactive ?? "far fa-circle" ?>"></i></span>
                    <span class="active"><i class="<?= $button_right_icon_active ?? "far fa-check-circle" ?>"></i></span>
                </span>
                <span><?= empty($value["escape_title"]) ? Language($value["title"] ?? "text") : ($value["title"] ?? "") ?></span>
            </label>
            <?php endforeach; ?>
            </nav>
	</section>
    <?php endif; ?>
</div>