<?php
session_start();
if ($_SESSION['user'] !== 'admin') exit;

$user = $_GET['user'] ?? '';
$type = $_GET['type'] ?? 'json';
$path = __DIR__ . "/data/bookmarks/{$user}.json";

if (!file_exists($path)) exit("File not found.");

$data = json_decode(file_get_contents($path), true);

if ($type === 'json') {
    header("Content-Type: application/json");
    header("Content-Disposition: attachment; filename=\"{$user}_bookmarks.json\"");
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"{$user}_bookmarks.csv\"");

$output = fopen("php://output", "w");
fputcsv($output, ['Category', 'Label', 'URL']);

foreach ($data['categories'] as $cat) {
    foreach ($cat['links'] as $link) {
        fputcsv($output, [$cat['title'], $link['label'], $link['url']]);
    }
}
fclose($output);
exit;
