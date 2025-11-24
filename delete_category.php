<?php
$dataPath = __DIR__ . "/data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);

$catIndex = $_POST['cat'] ?? null;

if (isset($board['categories'][$catIndex])) {
    array_splice($board['categories'], $catIndex, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
