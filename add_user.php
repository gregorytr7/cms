<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $email, $password, $role]);

  header("Location: users.php?msg=User added");
  exit;
}
?>

<!-- HTML form -->
<form method="POST">
  <input type="text" name="name" required placeholder="Full Name" />
  <input type="email" name="email" required placeholder="Email" />
  <input type="password" name="password" required placeholder="Password" />
  <select name="role" required>
    <option value="admin">Admin</option>
    <option value="pastor">Pastor</option>
    <option value="staff">Staff</option>
    <select name="member_id">
  <option value="">Link to member (optional)</option>
  <?php
  $members = $pdo->query("SELECT id, full_name FROM members")->fetchAll();
  foreach ($members as $m) {
    echo "<option value='{$m['id']}'>{$m['full_name']}</option>";
  }
  ?>
</select>

  </select>
  <button type="submit">Create User</button>
</form>
