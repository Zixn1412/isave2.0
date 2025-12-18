<?php
require_once 'functions.php';
require_role('admin');
if (!isset($_GET['id']) || !isset($_GET['act'])) { header('Location: recruit.php'); exit; }
$id = intval($_GET['id']);
$act = $_GET['act'];
if ($act === 'approve' && isset($_GET['role'])) {
    $role = $_GET['role'];
    // find the application and update user's role
    $res = $mysqli->query("SELECT user_id FROM applications WHERE id={$id}");
    $a = $res->fetch_assoc();
    $uid = intval($a['user_id']);
    $mysqli->query("UPDATE users SET role='".$mysqli->real_escape_string($role)."' WHERE id={$uid}");
    $mysqli->query("UPDATE applications SET status='approved' WHERE id={$id}");
} elseif ($act === 'reject') {
    $mysqli->query("UPDATE applications SET status='rejected' WHERE id={$id}");
}
header('Location: recruit.php'); exit;
?>