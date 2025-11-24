<?php
$dataPath = __DIR__ . "/data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Linkly</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="top-bar">
    <h1 class="title">Linkly</h1>
    <button id="show-add-category" class="btn-primary">+ Category</button>
</div>

<div id="add-category-panel" class="add-category-panel hidden">
    <input type="text" id="new-cat-title" placeholder="New category name">
    <button id="add-category-btn" class="btn-primary">Add</button>
</div>

<div id="board">
    <?php foreach ($board['categories'] as $catIndex => $category): ?>
        <div class="category-card" data-cat="<?= $catIndex ?>">
            <div class="category-header">
                <span class="category-title"><?= htmlspecialchars($category['title']) ?></span>
                <div class="category-actions">
                    <button class="icon-btn add-link-icon" data-cat="<?= $catIndex ?>" title="Add link">＋</button>
                    <button class="icon-btn delete-cat" data-cat="<?= $catIndex ?>" title="Delete category">✕</button>
                </div>
            </div>

            <div class="links">
                <?php foreach ($category['links'] as $linkIndex => $link): ?>
                    <div class="link-row">
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank">
                            <?= htmlspecialchars($link['label']) ?>
                        </a>
                        <button class="icon-btn delete-link"
                                data-cat="<?= $catIndex ?>"
                                data-link="<?= $linkIndex ?>"
                                title="Delete link">✕</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Add Link Modal -->
<div id="modal-backdrop" class="modal-backdrop hidden"></div>
<div id="add-link-modal" class="modal hidden">
    <div class="modal-content">
        <h2>Add Link</h2>
        <input type="text" id="modal-label" placeholder="Label">
        <input type="text" id="modal-url" placeholder="URL (https://...)">
        <div class="modal-actions">
            <button id="modal-cancel" class="btn-secondary">Cancel</button>
            <button id="modal-save" class="btn-primary">Add</button>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
