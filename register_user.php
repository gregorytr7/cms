<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $email, $password, $role]);

  header('Location: users.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add User</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Add New User</h1>
    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" class="w-full mb-3 p-2 border rounded" required>
      <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
      <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
      <select name="role" class="w-full mb-4 p-2 border rounded" required>
        <option value="admin">Admin</option>
        <option value="pastor">Pastor</option>
        <option value="staff">Staff</option>
        <option value="member">Member</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
    </form>
  </div>
</body>
</html>
