<?php
require_once 'auth.php';
require_once 'db.php';
$role = $_SESSION['user']['role'];
?>

<h2>Welcome, <?= ucfirst($role) ?>!</h2>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
  <div class="row">
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Total Members</h5>
          <p class="card-text">247</p>
        </div>
      </div>
    </div>
    <!-- More cards here -->
  </div>
</div>


<div class="dashboard-cards">
  <?php if ($role !== 'member'): ?>
    <!-- Total Members -->
    <div class="card">
      <h4>Total Members</h4>
      <p>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) FROM members");
        echo $stmt->fetchColumn();
        ?>
      </p>
    </div>

    <!-- This Week's Attendance -->
    <div class="card">
      <h4>This Week's Attendance</h4>
      <p>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) FROM attendance WHERE WEEK(date) = WEEK(CURDATE())");
        echo $stmt->fetchColumn();
        ?>
      </p>
    </div>

    <!-- Monthly Giving -->
    <div class="card">
      <h4>Monthly Giving</h4>
      <p>
        <?php
        $stmt = $pdo->query("SELECT SUM(amount) FROM donations WHERE MONTH(date) = MONTH(CURDATE())");
        echo '$' . number_format($stmt->fetchColumn(), 2);
        ?>
      </p>
    </div>
  <?php endif; ?>

  <!-- Upcoming Events -->
  <div class="card">
    <h4>Upcoming Events</h4>
    <p>
      <?php
      $stmt = $pdo->query("SELECT COUNT(*) FROM events WHERE date >= CURDATE()");
      echo $stmt->fetchColumn();
      ?>
    </p>
  </div>

  <?php if ($role === 'member'): ?>
    <!-- My Contributions -->
    <div class="card">
      <h4>My Contributions</h4>
      <p>
        <?php
        $user_id = $_SESSION['user']['id'];
        $stmt = $pdo->prepare("SELECT SUM(amount) FROM donations WHERE user_id = ?");
        $stmt->execute([$user_id]);
        echo '$' . number_format($stmt->fetchColumn(), 2);
        ?>
      </p>
    </div>

    <!-- My Attendance -->
    <div class="card">
      <h4>My Attendance</h4>
      <p>
        <?php
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE user_id = ?");
        $stmt->execute([$user_id]);
        echo $stmt->fetchColumn() . ' events';
        ?>
      </p>
    </div>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx1 = document.getElementById('attendanceChart').getContext('2d');
  const attendanceChart = new Chart(ctx1, {
    type: 'line',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: 'Attendance',
        data: <?= json_encode($attendanceData) ?>,
        borderColor: '#4ade80',
        tension: 0.4
      }]
    }
  });

  const ctx2 = document.getElementById('donationChart').getContext('2d');
  const donationChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: 'Donations',
        data: <?= json_encode($donationData) ?>,
        backgroundColor: '#60a5fa'
      }]
    }
  });
</script>

