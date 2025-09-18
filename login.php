<?php
session_start();
require_once 'db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$_POST['email']]);
  $user = $stmt->fetch();

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user'] = $user;
    header('Location: dashboard.php');
    exit;
  } else {
    $error = "Invalid credentials. Please try again.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Online Shop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="email" name="email" required placeholder="Email">
      <input type="password" name="password" required placeholder="Password">
      <button type="submit">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
