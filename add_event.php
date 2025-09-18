<?php
// add_event.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $date = $_POST['date'] ?? '';
  $time = $_POST['time'] ?? '';
  $attendees = $_POST['attendees'] ?? 0;

  $stmt = $pdo->prepare("INSERT INTO events (title, event_date, event_time, attendees_expected) VALUES (?, ?, ?, ?)");
  $stmt->execute([$title, $date, $time, $attendees]);

  header('Location: events.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Event</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Create New Event</h1>
    <form method="POST">
      <label class="block mb-2 text-sm">Title</label>
      <input name="title" class="w-full mb-4 p-2 border rounded" required>

      <label class="block mb-2 text-sm">Date</label>
      <input name="date" type="date" class="w-full mb-4 p-2 border rounded" required>

      <label class="block mb-2 text-sm">Time</label>
      <input name="time" type="time" class="w-full mb-4 p-2 border rounded" required>

      <label class="block mb-2 text-sm">Expected Attendees</label>
      <input name="attendees" type="number" class="w-full mb-4 p-2 border rounded" required>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Event</button>
    </form>
  </div>
</body>
</html>
