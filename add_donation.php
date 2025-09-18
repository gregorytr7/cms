<?php
require_once 'db.php';
session_start();

if (!in_array($_SESSION['user']['role'], ['admin', 'pastor', 'staff'])) {
  header('Location: dashboard.php');
  exit;
}

// Fetch members for dropdown
$members = $pdo->query("SELECT id, name FROM users WHERE role = 'member'")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $member_id = $_POST['member_id'];
  $amount = $_POST['amount'];
  $method = $_POST['method'];

  $stmt = $pdo->prepare("INSERT INTO donations (member_id, amount, method) VALUES (?, ?, ?)");
  $stmt->execute([$member_id, $amount, $method]);

  header("Location: donations.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Donation</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add New Donation</h2>
    <form method="POST">
      <label>Member</label>
      <select name="member_id" class="w-full p-2 border rounded mb-3" required>
        <?php foreach ($members as $member): ?>
          <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Amount</label>
      <input type="number" step="0.01" name="amount" class="w-full p-2 border rounded mb-3" required>

      <label>Method</label>
      <select name="method" class="w-full p-2 border rounded mb-4" required>
        <option value="cash">Cash</option>
        <option value="card">Card</option>
        <option value="bank">Bank</option>
        <option value="mobile">Mobile</option>
      </select>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Donation</button>
    </form>
  </div>
</body>
</html>
