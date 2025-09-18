<?php
require_once 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
  $stmt->execute([$name, $email, $role, $id]);
  header("Location: users.php?msg=User updated");
  exit;
}
?>

<form method="POST">
  <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required />
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required />
  <select name="role">
    <?php foreach (['admin', 'pastor', 'staff', 'member'] as $r): ?>
      <option value="<?= $r ?>" <?= $r === $user['role'] ? 'selected' : '' ?>><?= ucfirst($r) ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Update</button>
</form>
