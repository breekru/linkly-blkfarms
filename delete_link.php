<?php
$dataPath = "data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);

$cat = $_POST['cat'];
$index = $_POST['index'];

if (isset($board['categories'][$cat]['links'][$index])) {
    array_splice($board['categories'][$cat]['links'], $index, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
