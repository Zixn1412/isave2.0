<?php
require_once 'functions.php';
require_role('admin');
$user = current_user();

// Approve/Reject actions handled in separate script approve.php
include 'header.php';
?>
<h4>Admin - ตรวจสอบการแจ้งซ่อม</h4>

<div class="row">
  <div class="col-md-8">
    <h5>รายการรอตรวจสอบ</h5>
    <?php
    $res = $mysqli->query("SELECT r.*, u.username as reporter FROM reports r JOIN users u ON u.id=r.user_id WHERE r.status='pending' ORDER BY r.created_at DESC");
    while ($r = $res->fetch_assoc()):
    ?>
      <div class="card mb-2">
        <div class="card-body">
          <h6>เลข: <?=htmlspecialchars($r['asset_number'])?> — รายโดย: <?=htmlspecialchars($r['reporter'])?></h6>
          <p><?=nl2br(htmlspecialchars($r['reason']))?></p>
          <?php if ($r['image_path']): ?><img src="<?=htmlspecialchars($r['image_path'])?>" style="max-width:200px" class="img-fluid mb-2"><?php endif; ?>
          <div>
            <a href="approve.php?act=approve&id=<?=$r['id']?>" class="btn btn-success btn-sm">อนุมัติ</a>
            <a href="approve.php?act=reject&id=<?=$r['id']?>" class="btn btn-danger btn-sm">ไม่อนุมัติ</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="col-md-4">
    <h5>มอบหมายให้ช่าง</h5>
    <p>เลือกการแจ้งซ่อมที่อนุมัติแล้วเพื่อมอบหมาย</p>
    <?php
    $approved = $mysqli->query("SELECT r.* FROM reports r WHERE r.status='approved' ORDER BY r.updated_at DESC");
    $techs = $mysqli->query("SELECT id,username,fullname FROM users WHERE role='technician'");
    ?>
    <form method="post" action="assign.php">
      <div class="mb-3">
        <label>เลือกการแจ้งซ่อม</label>
        <select name="report_id" class="form-select">
          <?php while ($a = $approved->fetch_assoc()): ?>
            <option value="<?=$a['id']?>"><?=htmlspecialchars($a['asset_number'].' — '.$a['reason'])?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>เลือกช่าง</label>
        <select name="tech_id" class="form-select">
          <?php while ($t = $techs->fetch_assoc()): ?>
            <option value="<?=$t['id']?>"><?=htmlspecialchars($t['fullname']?:$t['username'])?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <button class="btn btn-primary">มอบหมาย</button>
    </form>
  </div>
</div>

<hr>
<h5>จัดการการรับสมัคร (Admin/ช่าง)</h5>
<p><a href="recruit.php" class="btn btn-outline-secondary">ไปหน้ารับสมัคร</a></p>

<?php include 'footer.php'; ?>