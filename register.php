<?php
require_once 'functions.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    if (!$username || !$password) $message = 'กรุณากรอกข้อมูลให้ครบ';
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare('INSERT INTO users (username,password,fullname,email) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss',$username,$hash,$fullname,$email);
        if ($stmt->execute()) {
            $message = 'สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ';
        } else $message = 'ไม่สามารถสมัครได้: '.$mysqli->error;
    }
}
include 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>สมัครสมาชิก</h4>
        <?php if ($message): ?><div class="alert alert-info"><?=$message?></div><?php endif; ?>
        <form method="post">
          <div class="row">
            <div class="col-md-6 mb-3"><label>ชื่อผู้ใช้</label><input class="form-control" name="username" required></div>
            <div class="col-md-6 mb-3"><label>รหัสผ่าน</label><input type="password" class="form-control" name="password" required></div>
          </div>
          <div class="mb-3"><label>ชื่อ-นามสกุล</label><input class="form-control" name="fullname"></div>
          <div class="mb-3"><label>อีเมล</label><input class="form-control" name="email" type="email"></div>
          <button class="btn btn-success">สมัคร</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>