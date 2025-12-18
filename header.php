<?php
require_once 'functions.php';
$user = current_user();
?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ระบบแจ้งซ่อมครุภัณฑ์ isave</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">isave - ระบบแจ้งซ่อมครุภัณฑ์</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto">
        <?php if ($user): ?>
          <li class="nav-item"><a class="nav-link">ยินดีต้อนรับ: <?=htmlspecialchars($user['fullname']?:$user['username'])?></a></li>
          <?php if ($user['role']=='admin'): ?>
            <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></li>
          <?php endif; ?>
          <?php if ($user['role']=='technician'): ?>
            <li class="nav-item"><a class="nav-link" href="technician_dashboard.php">ช่าง</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="submit_report.php">แจ้งซ่อม</a></li>
          <li class="nav-item"><a class="nav-link" href="recruit.php">รับสมัคร admin/ช่าง</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php">เข้าสู่ระบบ</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-4">
