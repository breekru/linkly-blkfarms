<?php
session_start();
if ($_SESSION['user'] !== 'admin') exit;

$user = $_POST['user'] ?? '';
$targetFile = __DIR__ . "/data/bookmarks/{$user}.json";

if (!preg_match('/^[a-zA-Z0-9_-]+$/', $user)) exit("Invalid user");

file_put_contents($targetFile, json_encode([
    "categories" => [
        [
            "title" => "Favorites",
            "links" => []
        ]
    ]
], JSON_PRETTY_PRINT));

header("Location: admin.php");
exit;
