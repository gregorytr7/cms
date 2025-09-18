<?php
require_once 'db.php';
session_start();

// Only admin, pastor, or staff can access
if (!in_array($_SESSION['user']['role'], ['admin', 'pastor', 'staff'])) {
  header('Location: dashboard.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $location = $_POST['location'];

  $stmt = $pdo->prepare("INSERT INTO events (title, description, date, time, location) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$title, $description, $date, $time, $location]);

  header("Location: events.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Event</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Create New Event</h2>
    <form method="POST">
      <input type="text" name="title" placeholder="Event Title" class="w-full mb-3 p-2 border rounded" required>
      <textarea name="description" placeholder="Description" class="w-full mb-3 p-2 border rounded"></textarea>
      <input type="date" name="date" class="w-full mb-3 p-2 border rounded" required>
      <input type="time" name="time" class="w-full mb-3 p-2 border rounded" required>
      <input type="text" name="location" placeholder="Location" class="w-full mb-4 p-2 border rounded">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Event</button>
    </form>
  </div>
</body>
</html>
