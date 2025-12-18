<?php
require_once 'functions.php';
if (!is_logged_in()) {
    header('Location: index.php');
    exit;
}
$user = current_user();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asset_number = $_POST['asset_number'] ?? '';
    $room = $_POST['room'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $warranty = isset($_POST['warranty']) ? 1 : 0;
    $responsible_person = $_POST['responsible_person'] ?? '';
    // handle image upload
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newname = uniqid('img_').'.'.preg_replace('/[^a-z0-9]/i','',$ext);
        $target = 'uploads/'.$newname;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $target;
        }
    }
    $stmt = $mysqli->prepare('INSERT INTO reports (user_id,asset_number,image_path,room,reason,warranty,responsible_person) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('isssiss', $user['id'], $asset_number, $image_path, $room, $reason, $warranty, $responsible_person);
    if ($stmt->execute()) {
        $message = 'ส่งแบบฟอร์มสำเร็จ';
    } else $message = 'เกิดข้อผิดพลาด: '.$mysqli->error;
}
include 'header.php';
?>
<div class="card shadow-sm">
  <div class="card-body">
    <h4>ฟอร์มแจ้งซ่อม</h4>
    <?php if ($message): ?><div class="alert alert-success"><?=$message?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>เลขครุภัณฑ์</label><input class="form-control" name="asset_number" required></div>
      <div class="mb-3"><label>แนบรูปภาพ (ถ้ามี)</label><input type="file" class="form-control" name="image" accept="image/*"></div>
      <div class="mb-3"><label>ห้อง</label><input class="form-control" name="room"></div>
      <div class="mb-3"><label>สาเหตุที่พัง / รายละเอียด</label><textarea class="form-control" name="reason" rows="3"></textarea></div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="warranty" name="warranty">
        <label class="form-check-label" for="warranty">มีประกัน</label>
      </div>
      <div class="mb-3"><label>ผู้รับผิดชอบ</label><input class="form-control" name="responsible_person"></div>
      <button class="btn btn-primary">ส่งแบบฟอร์ม</button>
      <button type="reset" class="btn btn-secondary">ล้างข้อมูล</button>
    </form>
  </div>
</div>

<!-- list user's reports -->
<div class="mt-4">
  <h5>รายการที่แจ้งไว้</h5>
  <div class="list-group">
    <?php
    $uid = $user['id'];
    $res = $mysqli->query("SELECT r.*, u.username FROM reports r LEFT JOIN users u ON u.id=r.assigned_to WHERE r.user_id={$uid} ORDER BY r.created_at DESC");
    while ($row = $res->fetch_assoc()):
    ?>
      <div class="list-group-item">
        <div class="d-flex w-100 justify-content-between">
          <h6 class="mb-1">เลข: <?=htmlspecialchars($row['asset_number'])?> — สถานะ: <?=htmlspecialchars($row['status'])?></h6>
          <small><?=htmlspecialchars($row['created_at'])?></small>
        </div>
        <p class="mb-1"><?=nl2br(htmlspecialchars($row['reason']))?></p>
        <?php if ($row['image_path']): ?><img src="<?=htmlspecialchars($row['image_path'])?>" class="img-fluid" style="max-width:200px"><?php endif; ?>
        <?php if ($row['assigned_to']): ?><div>ช่างรับผิดชอบ: <?=htmlspecialchars($row['username'])?></div><?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>


<?php include 'footer.php'; ?>