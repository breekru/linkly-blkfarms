<?php
$usersFile = __DIR__ . "/data/users.json";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = "Username and password required.";
    } else {
        $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : ['users' => []];
        foreach ($users['users'] as $u) {
            if ($u['username'] === $username) {
                $error = "User already exists.";
                break;
            }
        }

        if (!isset($error)) {
            $users['users'][] = [
                'username' => $username,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'created' => date("Y-m-d")
            ];
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
            header("Location: auth/login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register - Linkly</title></head>
<body>
<h2>Register</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account?</a>
</body>
</html>
