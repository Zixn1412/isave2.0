<?php
require_once 'functions.php';
if (!is_logged_in()) { header('Location: index.php'); exit; }
$user = current_user();
include 'header.php';

// submit application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['desired_role'])) {
    $desired = $_POST['desired_role'];
    $uid = $user['id'];
    $stmt = $mysqli->prepare('INSERT INTO applications (user_id,desired_role) VALUES (?,?)');
    $stmt->bind_param('is',$uid,$desired);
    $stmt->execute();
    echo '<div class="alert alert-success">ส่งคำขอแล้ว</div>';
}

// if admin, show pending applications
if ($user['role']=='admin') {
    echo '<h5>คำขอเป็น admin/ช่าง (รออนุมัติ)</h5>';
    $apps = $mysqli->query("SELECT a.*, u.username, u.fullname FROM applications a JOIN users u ON u.id=a.user_id WHERE a.status='pending'");
    while ($a = $apps->fetch_assoc()) {
        echo '<div class="card mb-2"><div class="card-body">';
        echo '<b>'.htmlspecialchars($a['fullname']?:$a['username']).'</b> ขอตำแหน่ง: '.htmlspecialchars($a['desired_role']);
        echo '<div class="mt-2"><a class="btn btn-success btn-sm" href="handle_app.php?id='.$a['id'].'&act=approve&role='.$a['desired_role'].'">อนุมัติ</a> ';
        echo '<a class="btn btn-danger btn-sm" href="handle_app.php?id='.$a['id'].'&act=reject">ปฏิเสธ</a></div>';
        echo '</div></div>';
    }
} else {
    // normal user application form
    echo '<div class="card"><div class="card-body"><h5>สมัครเป็น Admin/ช่าง</h5>';
    echo '<form method="post"><label>เลือกตำแหน่งที่ต้องการ</label><select name="desired_role" class="form-select"><option value="admin">Admin</option><option value="technician">ช่าง</option></select><br><button class="btn btn-primary">ส่งคำขอ</button></form></div></div>';
}

include 'footer.php';
?>