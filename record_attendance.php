<?php
// record_attendance.php
require_once 'db.php';

// Fetch members list
$members = $pdo->query("SELECT id, full_name FROM members ORDER BY full_name ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $date = $_POST['date'] ?? date('Y-m-d');
  $present_ids = $_POST['present'] ?? [];

  foreach ($present_ids as $member_id) {
    $stmt = $pdo->prepare("INSERT INTO attendance (member_id, attended_at) VALUES (?, ?)");
    $stmt->execute([$member_id, $date]);
  }

  header("Location: attendance.php?date=" . $date);
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Record Attendance</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Record Attendance</h1>

    <form method="POST">
      <label class="block mb-2 text-sm">Date</label>
      <input name="date" type="date" class="w-full p-2 border mb-4 rounded" value="<?= date('Y-m-d') ?>" required>

      <label class="block mb-2 text-sm">Select Present Members</label>
      <div class="h-64 overflow-y-scroll border p-4 rounded mb-4">
        <?php foreach ($members as $member): ?>
          <div>
            <label class="inline-flex items-center">
              <input type="checkbox" name="present[]" value="<?= $member['id'] ?>" class="mr-2">
              <?= htmlspecialchars($member['full_name']) ?>
            </label>
          </div>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Submit Attendance
      </button>
    </form>
  </div>
</body>
</html>
