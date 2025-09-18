<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$_POST['email']]);
  $user = $stmt->fetch();

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user'] = $user;
    header('Location: dashboard.php');
    exit;
  } else {
    $error = "Invalid credentials";
  }
}
?>

<form method="POST">
  <input type="email" name="email" required placeholder="Email" />
  <input type="password" name="password" required placeholder="Password" />
  <button type="submit">Login</button>
</form>
<?= $error ?? '' ?>
