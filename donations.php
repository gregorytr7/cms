<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$role = $_SESSION['user']['role'];
$userId = $_SESSION['user']['id'];

if ($role === 'member') {
  $stmt = $pdo->prepare("SELECT d.*, u.name FROM donations d JOIN users u ON d.member_id = u.id WHERE member_id = ? ORDER BY donated_at DESC");
  $stmt->execute([$userId]);
} else {
  $stmt = $pdo->query("SELECT d.*, u.name FROM donations d JOIN users u ON d.member_id = u.id ORDER BY donated_at DESC");
}

$donations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Donations</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Donation Records</h2>
      <?php if (in_array($role, ['admin', 'pastor', 'staff'])): ?>
        <a href="add_donation.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add Donation</a>
      <?php endif; ?>
    </div>

    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Member</th>
          <th class="p-2">Amount</th>
          <th class="p-2">Method</th>
          <th class="p-2">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($donations as $d): ?>
        <tr class="border-t">
          <td class="p-2"><?= htmlspecialchars($d['name']) ?></td>
          <td class="p-2">$<?= $d['amount'] ?></td>
          <td class="p-2"><?= ucfirst($d['method']) ?></td>
          <td class="p-2"><?= $d['donated_at'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
