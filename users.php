<?php
require_once 'db.php';
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<h2>All Users</h2>
<a href="add_user.php">+ Add User</a>
<table>
  <tr><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= $u['role'] ?></td>
      <td>
        <a href="edit_user.php?id=<?= $u['id'] ?>">Edit</a>
        <a href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
