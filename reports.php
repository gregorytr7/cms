<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'pastor', 'staff'])) {
  header("Location: login.php");
  exit;
}

// Donations this month
$donationsStmt = $pdo->query("
  SELECT 
    DATE_FORMAT(donated_at, '%Y-%m') AS month,
    SUM(amount) AS total
  FROM donations
  GROUP BY month
  ORDER BY month DESC
  LIMIT 6
");

$donationData = $donationsStmt->fetchAll(PDO::FETCH_ASSOC);

// Attendance by month
$attendanceStmt = $pdo->query("
  SELECT 
    DATE_FORMAT(event_date, '%Y-%m') AS month,
    SUM(attendees) AS total_attendance
  FROM attendance
  GROUP BY month
  ORDER BY month DESC
  LIMIT 6
");

$attendanceData = $attendanceStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reports</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow space-y-8">
    <h1 class="text-2xl font-bold mb-4">Church Reports</h1>

    <div>
      <h2 class="text-xl font-semibold mb-2">Donation Trends (Last 6 Months)</h2>
      <canvas id="donationChart" height="100"></canvas>
    </div>

    <div>
      <h2 class="text-xl font-semibold mb-2">Attendance Trends (Last 6 Months)</h2>
      <canvas id="attendanceChart" height="100"></canvas>
    </div>
  </div>

  <script>
    const donationCtx = document.getElementById('donationChart').getContext('2d');
    const donationChart = new Chart(donationCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode(array_column($donationData, 'month')) ?>,
        datasets: [{
          label: 'Total Donations ($)',
          data: <?= json_encode(array_column($donationData, 'total')) ?>,
          backgroundColor: 'rgba(59,130,246,0.2)',
          borderColor: 'rgba(59,130,246,1)',
          borderWidth: 2,
          fill: true
        }]
      }
    });

    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(attendanceCtx, {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($attendanceData, 'month')) ?>,
        datasets: [{
          label: 'Total Attendance',
          data: <?= json_encode(array_column($attendanceData, 'total_attendance')) ?>,
          backgroundColor: 'rgba(16,185,129,0.7)',
          borderColor: 'rgba(5,150,105,1)',
          borderWidth: 1
        }]
      }
    });
  </script>
</body>
</html>
