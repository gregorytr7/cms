<?php
require_once 'db.php';
session_start();

$events = $pdo->query("SELECT * FROM events ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Events</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Upcoming Events</h2>
      <?php if (in_array($_SESSION['user']['role'], ['admin', 'pastor', 'staff'])): ?>
        <a href="create_event.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ New Event</a>
      <?php endif; ?>
    </div>

    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Title</th>
          <th class="p-2">Date</th>
          <th class="p-2">Time</th>
          <th class="p-2">Location</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $event): ?>
        <tr class="border-t">
          <td class="p-2 font-medium"><?= htmlspecialchars($event['title']) ?></td>
          <td class="p-2"><?= $event['date'] ?></td>
          <td class="p-2"><?= $event['time'] ?></td>
          <td class="p-2"><?= htmlspecialchars($event['location']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
