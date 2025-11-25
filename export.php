<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) exit;

$type = $_GET['type'] ?? 'json'; // json or csv
$path = __DIR__ . "/data/bookmarks/{$user}.json";

if (!file_exists($path)) exit("No bookmarks found.");

$board = json_decode(file_get_contents($path), true);

if ($type === 'json') {
    header("Content-Type: application/json");
    header("Content-Disposition: attachment; filename=\"{$user}_bookmarks.json\"");
    echo json_encode($board, JSON_PRETTY_PRINT);
    exit;
}

// CSV export
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"{$user}_bookmarks.csv\"");

$output = fopen("php://output", "w");
fputcsv($output, ['Category', 'Label', 'URL']);

foreach ($board['categories'] as $category) {
    $cat = $category['title'];
    foreach ($category['links'] as $link) {
        fputcsv($output, [$cat, $link['label'], $link['url']]);
    }
}
fclose($output);
exit;
