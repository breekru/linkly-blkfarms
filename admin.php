<?php
session_start();
$user = $_SESSION['user'] ?? null;

$usersFile = __DIR__ . "/data/users.json";
$bookmarksDir = __DIR__ . "/data/bookmarks/";

$users = json_decode(file_get_contents($usersFile), true)['users'] ?? [];

$isAdmin = false;
foreach ($users as $u) {
    if ($u['username'] === $user && ($u['role'] ?? '') === 'admin') {
        $isAdmin = true;
        break;
    }
}

if (!$isAdmin) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Panel - Linkly</title></head>
<body>
<h2>Admin Panel</h2>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
  <th>User</th>
  <th>Download JSON</th>
  <th>Download CSV</th>
  <th>Reset Bookmarks</th>
</tr>

<?php foreach ($users as $u):
  $uName = $u['username'];
  $hasFile = file_exists($bookmarksDir . $uName . ".json");
?>
<tr>
  <td><?= htmlspecialchars($uName) ?></td>
  <td>
    <?php if ($hasFile): ?>
      <a href="admin_export.php?user=<?= urlencode($uName) ?>&type=json">JSON</a>
    <?php else: ?>
      —
    <?php endif; ?>
  </td>
  <td>
    <?php if ($hasFile): ?>
      <a href="admin_export.php?user=<?= urlencode($uName) ?>&type=csv">CSV</a>
    <?php else: ?>
      —
    <?php endif; ?>
  </td>
  <td>
    <form method="post" action="admin_reset.php" onsubmit="return confirm('Reset <?= $uName ?> bookmarks?')">
      <input type="hidden" name="user" value="<?= htmlspecialchars($uName) ?>">
      <button type="submit">Reset</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
