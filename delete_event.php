<?php
require_once 'db.php';
session_start();

if ($_SESSION['user']['role'] !== 'admin') {
  header("Location: events.php");
  exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
  $stmt->execute([$id]);
}

header("Location: events.php");
exit;
