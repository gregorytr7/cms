<?php
$role = $_SESSION['user']['role']; // e.g., 'admin', 'pastor', etc.
?>

<ul class="sidebar">
  <li><a href="/dashboard.php">Dashboard</a></li>
  
  <?php if ($role === 'admin' || $role === 'pastor' || $role === 'staff'): ?>
    <li><a href="/members.php">Members</a></li>
    <li><a href="/events.php">Events</a></li>
    <li><a href="/attendance.php">Attendance</a></li>
    <li><a href="/giving.php">Giving</a></li>
    <li><a href="/communications.php">Communications</a></li>
  <?php endif; ?>

  <?php if ($role === 'member'): ?>
    <li><a href="/my-attendance.php">My Attendance</a></li>
    <li><a href="/my-giving.php">My Giving</a></li>
  <?php endif; ?>
</ul>
