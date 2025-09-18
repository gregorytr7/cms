<?php
// attendance.php
require_once 'db.php';

$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("
  SELECT m.full_name, a.attended_at 
  FROM attendance a
  JOIN members m ON m.id = a.member_id
  WHERE a.attended_at = ?
  ORDER BY m.full_name ASC
");
$stmt->execute([$date]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Attendance</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Attendance on <?= htmlspecialchars($date) ?></h1>

    <form method="GET" class="mb-4">
      <label for="date" class="text-sm">Select Date:</label>
      <input type="date" name="date" value="<?= $date ?>" class="border p-2 rounded ml-2">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-1 rounded">View</button>
    </form>

    <div class="bg-white p-4 rounded shadow">
      <?php if (count($records) === 0): ?>
        <p class="text-gray-600">No attendance recorded for this date.</p>
      <?php else: ?>
        <ul class="list-disc list-inside">
          <?php foreach ($records as $record): ?>
            <li><?= htmlspecialchars($record['full_name']) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="mt-4 text-sm text-gray-600">Total Present: <?= count($records) ?></p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
