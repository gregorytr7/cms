<?php
require_once 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);
header("Location: users.php?msg=User deleted");
exit;
