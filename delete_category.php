<?php
$dataPath = "data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);

$index = $_POST['index'];

if (isset($board['categories'][$index])) {
    array_splice($board['categories'], $index, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
