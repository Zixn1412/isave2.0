<?php
require_once 'functions.php';
require_role('admin');
if (!isset($_GET['act']) || !isset($_GET['id'])) { header('Location: admin_dashboard.php'); exit; }
$act = $_GET['act'];
$id = intval($_GET['id']);
if ($act === 'approve') {
    $mysqli->query("UPDATE reports SET status='approved' WHERE id={$id}");
} elseif ($act === 'reject') {
    $mysqli->query("UPDATE reports SET status='rejected' WHERE id={$id}");
}
header('Location: admin_dashboard.php'); exit;
?>