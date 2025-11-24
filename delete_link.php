<?php
$dataPath = __DIR__ . "/data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);

$catIndex = $_POST['cat'] ?? null;
$linkIndex = $_POST['link'] ?? null;

if (isset($board['categories'][$catIndex]['links'][$linkIndex])) {
    array_splice($board['categories'][$catIndex]['links'], $linkIndex, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
