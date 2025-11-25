<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) exit;

$dataPath = __DIR__ . "/data/bookmarks/{$user}.json";
$board = json_decode(file_get_contents($dataPath), true);

$cat = $_POST['cat'];
$link = $_POST['link'];

if (isset($board['categories'][$cat]['links'][$link])) {
    array_splice($board['categories'][$cat]['links'], $link, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
