<?php
require_once 'functions.php';
if (is_logged_in()) {
    header('Location: submit_report.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $mysqli->prepare('SELECT id,password FROM users WHERE username=?');
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: submit_report.php');
            exit;
        } else $message = 'รหัสผ่านไม่ถูกต้อง';
    } else $message = 'ไม่พบผู้ใช้';
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title">เข้าสู่ระบบ</h4>
        <?php if ($message): ?><div class="alert alert-warning"><?=$message?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label>ชื่อผู้ใช้</label>
            <input class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label>รหัสผ่าน</label>
            <input class="form-control" type="password" name="password" required>
          </div>
          <button class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
