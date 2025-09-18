<?php
// add_member.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $phone = $_POST['phone'] ?? '';

  $stmt = $pdo->prepare("INSERT INTO members (name, email, phone) VALUES (?, ?, ?)");
  $stmt->execute([$name, $email, $phone]);

  header('Location: members.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Member</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Add New Member</h1>
    <form method="POST">
      <label class="block mb-2 text-sm">Name</label>
      <input name="name" class="w-full mb-4 p-2 border rounded" required>

      <label class="block mb-2 text-sm">Email</label>
      <input name="email" type="email" class="w-full mb-4 p-2 border rounded">

      <label class="block mb-2 text-sm">Phone</label>
      <input name="phone" class="w-full mb-4 p-2 border rounded">

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Member</button>
    </form>
  </div>
</body>
</html>
