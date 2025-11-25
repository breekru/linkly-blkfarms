<?php
$usersFile = __DIR__ . "/data/users.json";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : ['users' => []];

    foreach ($users['users'] as $u) {
        if ($u['username'] === $username && password_verify($password, $u['password_hash'])) {
            $_SESSION['user'] = $username;
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Invalid credentials.";
}
?>

<!DOCTYPE html>
<html>
<head><title>Login - Linkly</title></head>
<body>
<h2>Login</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login</button>
</form>
<a href="auth/register.php">Need an account?</a>
</body>
</html>
