<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) exit;

$dataPath = __DIR__ . "/data/bookmarks/{$user}.json";
$board = json_decode(file_get_contents($dataPath), true);

$cat = $_POST['cat'];
$label = trim($_POST['label']);
$url = trim($_POST['url']);

if ($label && $url && isset($board['categories'][$cat])) {
    $board['categories'][$cat]['links'][] = [
        "label" => $label,
        "url" => $url
    ];
    file_put_contents($dataPath, json_encode($board, JSON_PRETTY_PRINT));
}
?>
