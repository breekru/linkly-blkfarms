<?php
// Load bookmarks
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

<h1 class="title">Linkly</h1>

<div id="board">
    <?php foreach ($board['categories'] as $i => $cat): ?>
        <div class="category" data-index="<?= $i ?>">
            <div class="cat-header">
                <span><?= htmlspecialchars($cat['title']) ?></span>
                <button class="delete-cat" data-index="<?= $i ?>">×</button>
            </div>

            <div class="links">
                <?php foreach ($cat['links'] as $j => $link): ?>
                    <div class="link-item">
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank">
                            <?= htmlspecialchars($link['label']) ?>
                        </a>
                        <button class="delete-link"
                                data-cat="<?= $i ?>" data-index="<?= $j ?>">×</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="add-link">
                <input type="text" placeholder="Label" class="label-input" data-cat="<?= $i ?>">
                <input type="text" placeholder="URL" class="url-input" data-cat="<?= $i ?>">
                <button class="add-link-button" data-cat="<?= $i ?>">Add Link</button>
            </div>
        </div>
    <?php endforeach; ?>

    <div id="new-category">
        <input type="text" id="new-cat-title" placeholder="New Category Name">
        <button id="add-category-btn">Add Category</button>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
