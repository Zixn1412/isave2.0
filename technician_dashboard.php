<?php
require_once 'functions.php';
require_role('technician');
$user = current_user();
include 'header.php';
?>
<h4>ช่าง - งานที่มอบหมาย</h4>
<?php
$res = $mysqli->query("SELECT r.*, u.username as reporter FROM reports r JOIN users u ON u.id=r.user_id WHERE r.assigned_to={$user['id']} ORDER BY r.created_at DESC");
while ($r = $res->fetch_assoc()):
?>
  <div class="card mb-2">
    <div class="card-body">
      <h6>เลข: <?=htmlspecialchars($r['asset_number'])?> — สถานะ: <?=htmlspecialchars($r['status'])?></h6>
      <p><?=nl2br(htmlspecialchars($r['reason']))?></p>
      <?php if ($r['image_path']): ?><img src="<?=htmlspecialchars($r['image_path'])?>" style="max-width:200px" class="img-fluid mb-2"><?php endif; ?>
      <form method="post" action="tech_update.php">
        <input type="hidden" name="report_id" value="<?=$r['id']?>">
        <div class="mb-2"><label>ชื่อช่าง / บริษัทที่ซ่อม</label><input class="form-control" name="tech_name" required></div>
        <div class="mb-2"><label>บันทึกการซ่อม</label><textarea class="form-control" name="tech_note" rows="3"></textarea></div>
        <button class="btn btn-success" name="action" value="start">เริ่มงาน</button>
        <button class="btn btn-primary" name="action" value="finish">เสร็จสิ้น</button>
      </form>
    </div>
  </div>
<?php endwhile; ?>

<?php include 'footer.php'; ?>