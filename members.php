<?php
// members.php
require_once 'db.php';

$members = $pdo->query("SELECT * FROM members ORDER BY joined_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Church Members</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Church Members</h1>
      <a href="add_member.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add Member</a>
    </div>
    <table class="w-full bg-white shadow rounded">
      <thead class="bg-gray-200 text-sm text-left">
        <tr>
          <th class="p-3">#</th>
          <th class="p-3">Name</th>
          <th class="p-3">Email</th>
          <th class="p-3">Phone</th>
          <th class="p-3">Joined</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($members as $index => $member): ?>
        <tr class="border-b">
          <td class="p-3"><?= $index + 1 ?></td>
          <td class="p-3"><?= htmlspecialchars($member['name']) ?></td>
          <td class="p-3"><?= htmlspecialchars($member['email']) ?></td>
          <td class="p-3"><?= htmlspecialchars($member['phone']) ?></td>
          <td class="p-3 text-sm text-gray-600"><?= date('M d, Y', strtotime($member['joined_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
