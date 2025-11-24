<?php
// dashboard.php

$dataPath = __DIR__ . "/data/bookmarks.json";

// Load board data safely
$board = ['categories' => []];
if (file_exists($dataPath)) {
    $json = file_get_contents($dataPath);
    $decoded = json_decode($json, true);
    if (is_array($decoded) && isset($decoded['categories']) && is_array($decoded['categories'])) {
        $board = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Linkly</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Top Bar -->
<header class="top-bar">
    <h1 class="logo">Linkly</h1>
    <button id="toggle-add-category" class="btn-primary">+ Category</button>
</header>

<!-- Add Category Panel (hidden until button clicked) -->
<section id="add-category-panel" class="add-category-panel hidden">
    <input type="text" id="new-category-title" placeholder="New category name">
    <button id="add-category-btn" class="btn-primary">Add</button>
</section>

<!-- Main Board -->
<main id="board">
    <?php foreach ($board['categories'] as $catIndex => $category): ?>
        <section class="category-card" data-cat="<?= (int)$catIndex ?>">
            <header class="category-header">
                <span class="category-title">
                    <?= htmlspecialchars($category['title'] ?? 'Untitled', ENT_QUOTES, 'UTF-8') ?>
                </span>
                <div class="category-actions">
                    <!-- Add link icon -->
                    <button class="icon-btn add-link-btn"
                            data-cat="<?= (int)$catIndex ?>"
                            title="Add link">＋</button>
                    <!-- Delete category icon -->
                    <button class="icon-btn delete-category-btn"
                            data-cat="<?= (int)$catIndex ?>"
                            title="Delete category">✕</button>
                </div>
            </header>

            <div class="links">
                <?php if (!empty($category['links']) && is_array($category['links'])): ?>
                    <?php foreach ($category['links'] as $linkIndex => $link): ?>
                        <div class="link-row">
                            <a href="<?= htmlspecialchars($link['url'] ?? '#', ENT_QUOTES, 'UTF-8') ?>"
                               target="_blank">
                                <?= htmlspecialchars($link['label'] ?? 'Untitled', ENT_QUOTES, 'UTF-8') ?>
                            </a>
                            <button class="icon-btn delete-link-btn"
                                    data-cat="<?= (int)$catIndex ?>"
                                    data-link="<?= (int)$linkIndex ?>"
                                    title="Delete link">✕</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<!-- Add Link Modal -->
<div id="modal-backdrop" class="modal-backdrop hidden"></div>

<div id="add-link-modal" class="modal hidden">
    <div class="modal-content">
        <h2>Add Link</h2>

        <label class="modal-label">
            Label
            <input type="text" id="modal-label-input" placeholder="e.g. Sumo Logic">
        </label>

        <label class="modal-label">
            URL
            <input type="text" id="modal-url-input" placeholder="https://example.com">
        </label>

        <div class="modal-actions">
            <button id="modal-cancel" class="btn-secondary">Cancel</button>
            <button id="modal-save" class="btn-primary">Add</button>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
