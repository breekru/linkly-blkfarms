<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) exit;

$path = __DIR__ . "/data/bookmarks/{$user}.json";
$existing = file_exists($path) ? json_decode(file_get_contents($path), true) : ["categories" => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['import_file'])) {
    $file = $_FILES['import_file'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    $newBoard = [];

    if ($ext === 'json') {
        $content = file_get_contents($file['tmp_name']);
        $parsed = json_decode($content, true);
        if (isset($parsed['categories'])) {
            $newBoard = $parsed;
        } else {
            die("Invalid JSON format.");
        }
    } elseif ($ext === 'csv') {
        $handle = fopen($file['tmp_name'], "r");
        $header = fgetcsv($handle);
        $grouped = [];

        while (($row = fgetcsv($handle)) !== false) {
            list($cat, $label, $url) = $row;
            $grouped[$cat][] = ["label" => $label, "url" => $url];
        }

        foreach ($grouped as $cat => $links) {
            $newBoard['categories'][] = [
                "title" => $cat,
                "links" => $links
            ];
        }
    } else {
        die("Unsupported file format.");
    }

    // Overwrite current bookmarks
    file_put_contents($path, json_encode($newBoard, JSON_PRETTY_PRINT));
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Import Bookmarks - Linkly</title></head>
<body>
<h2>Import Bookmarks</h2>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="import_file" required><br><br>
  <button type="submit">Import</button>
</form>
<a href="dashboard.php">Back to dashboard</a>
</body>
</html>
