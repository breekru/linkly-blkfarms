<?php
$dataPath = "data/bookmarks.json";
$board = json_decode(file_get_contents($dataPath), true);

$title = trim($_POST['title'] ?? '');
if ($title !== '') {
    $board['categories'][] = [
        "title" => $title,
        "links" => []
    ];
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
