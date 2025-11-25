<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) exit;

$dataPath = __DIR__ . "/data/bookmarks/{$user}.json";
$board = json_decode(file_get_contents($dataPath), true);

$cat = $_POST['cat'];

if (isset($board['categories'][$cat])) {
    array_splice($board['categories'], $cat, 1);
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
