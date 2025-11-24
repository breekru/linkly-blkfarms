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

<header class="top-bar">
  <h1 class="logo">Linkly</h1>
  <button id="toggle-category-panel" class="btn-primary">+ Category</button>
</header>

<section id="category-panel" class="category-panel hidden">
  <input type="text" id="new-category-title" placeholder="Category name">
  <button id="add-category-btn" class="btn-primary">Add</button>
</section>

<main id="board">
  <?php foreach ($board['categories'] as $catIndex => $cat): ?>
    <section class="category-card" data-cat="<?= $catIndex ?>">
      <header class="category-header">
        <span><?= htmlspecialchars($cat['title']) ?></span>
        <div class="category-actions">
          <button class="icon-btn add-link-btn" data-cat="<?= $catIndex ?>">＋</button>
          <button class="icon-btn delete-cat-btn" data-cat="<?= $catIndex ?>">✕</button>
        </div>
      </header>

      <div class="links">
        <?php foreach ($cat['links'] as $linkIndex => $link): ?>
          <div class="link-row">
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['label']) ?></a>
            <button class="icon-btn delete-link-btn"
                    data-cat="<?= $catIndex ?>"
                    data-link="<?= $linkIndex ?>">✕</button>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<!-- Modal -->
<div id="modal-backdrop" class="modal-backdrop hidden"></div>
<div id="add-link-modal" class="modal hidden">
  <div class="modal-content">
    <h2>Add Link</h2>
    <input type="text" id="link-label" placeholder="Label">
    <input type="text" id="link-url" placeholder="URL (https://...)">
    <div class="modal-actions">
      <button id="cancel-modal" class="btn-secondary">Cancel</button>
      <button id="save-link" class="btn-primary">Add</button>
    </div>
  </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
