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

<h1 class="title">Linkly</h1>

<div id="board">

<?php foreach ($board['categories'] as $catIndex => $category): ?>
    <div class="category-card">

        <div class="category-header">
            <span><?= htmlspecialchars($category['title']) ?></span>
            <button class="delete-category-btn" data-cat="<?= $catIndex ?>">✕</button>
        </div>

        <div class="links">
            <?php foreach ($category['links'] as $linkIndex => $link): ?>
                <div class="link-row">
                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank">
                        <?= htmlspecialchars($link['label']) ?>
                    </a>
                    <button class="delete-link-btn"
                            data-cat="<?= $catIndex ?>"
                            data-link="<?= $linkIndex ?>">✕</button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="add-link-form">
            <input type="text" placeholder="Label" class="new-label" data-cat="<?= $catIndex ?>">
            <input type="text" placeholder="URL" class="new-url" data-cat="<?= $catIndex ?>">
            <button class="add-link-btn" data-cat="<?= $catIndex ?>">Add Link</button>
        </div>

    </div>
<?php endforeach; ?>

    <div class="new-category-card">
        <input type="text" id="new-category-title" placeholder="New Category Name">
        <button id="add-category-btn">Add Category</button>
    </div>

</div>

<script src="js/main.js"></script>

</body>
</html>
