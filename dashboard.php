<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: auth/login.php");
  exit;
}
?>


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
  <div style="font-size:14px;">
  Logged in as <?= htmlspecialchars($_SESSION['user']) ?> |
  <a href="logout.php" style="color:#4DB8FF;">Logout</a>
</div>

  <button id="toggle-category-form" class="btn">+ Category</button>
</header>

<div id="category-form" class="dropdown hidden">
  <input type="text" id="new-category-title" placeholder="Category name">
  <button id="add-category-btn" class="btn small">Add</button>
</div>

<main id="board">
  <?php foreach ($board['categories'] as $catIndex => $cat): ?>
    <section class="card" data-cat="<?= $catIndex ?>">
      <div class="card-header">
        <span><?= htmlspecialchars($cat['title']) ?></span>
        <div class="card-actions">
          <button class="icon add-link" data-cat="<?= $catIndex ?>">＋</button>
          <button class="icon delete-cat" data-cat="<?= $catIndex ?>">✕</button>
        </div>
      </div>
      <div class="links">
        <?php foreach ($cat['links'] as $linkIndex => $link): ?>
          <div class="link-row">
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['label']) ?></a>
            <button class="icon delete-link" data-cat="<?= $catIndex ?>" data-link="<?= $linkIndex ?>">✕</button>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<!-- Modal -->
<div id="modal-backdrop" class="modal-backdrop hidden"></div>
<div id="modal" class="modal hidden">
  <div class="modal-box">
    <h2>Add Link</h2>
    <input type="text" id="modal-label" placeholder="Label">
    <input type="text" id="modal-url" placeholder="URL (https://...)">
    <div class="modal-actions">
      <button id="cancel-modal" class="btn cancel">Cancel</button>
      <button id="save-link" class="btn">Add</button>
    </div>
  </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
