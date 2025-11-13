<?= !empty($before) ? (is_callable($before) ? $before() : $before) : "" ?>
<?php if(!empty($show) || !isset($show)): ?>
<input type="checkbox" class="check-dropdown" id="check-show-<?= $id ?? "empty" ?>" <?= !empty($checked) ? "checked" : "" ?> hidden>
<div class="dropdown">
    <header class="dropdown__header">
        <label for="check-show-<?= $id ?? "empty" ?>">
            <span class="icon <?= !empty($title) ? "icon--left" : "" ?>">
                <span class="inactive"><i class="<?= $button_menu_icon_inactive ?? "fas fa-bars" ?>"></i></span>
                <span class="active"><i class="<?= $button_menu_icon_active ?? "fas fa-times" ?>"></i></span>
            </span>
            <strong><?= empty($escape_title) ? Language($title ?? "text") : ($title ?? "") ?></strong>
        </label>
        <div class="flex items-center">
            <?php if(!empty($button_right_show)): ?>
            <div class="inputs-checkbox flex gap-0">
                <input type="checkbox" name="<?= $button_right_name ?? "show" ?>" id="check-enable-<?= $button_right_id ?? "show" ?>" <?= !empty($button_right_checked) ? "checked" : "" ?>>
                <label for="check-enable-<?= $button_right_id ?? "show" ?>">
                    <div class="icon <?= !empty($button_right_text) ? "icon--left" : "" ?>">
                        <span class="inactive"><i class="<?= $button_right_icon_inactive ?? "far fa-circle" ?>"></i></span>
                        <span class="active"><i class="<?= $button_right_icon_active ?? "far fa-check-circle" ?>"></i></span>
                    </div>
                    <div class="text"><?= Language($button_right_text ?? "show") ?></div>
                </label>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <section class="dropdown__main">
        <div class="dropdown_content">
            <?= !empty($content_before) ? (is_callable($content_before) ? $content_before() : $content_before) : "" ?>
            <?= !empty($content) ? (is_callable($content) ? $content() : $content) : "" ?>
            <?= !empty($content_after) ? (is_callable($content_after) ? $content_after() : $content_after) : "" ?>
        </div>
    </section>
</div>
<?php endif; ?>
<?= !empty($after) ? (is_callable($after) ? $after() : $after) : "" ?>