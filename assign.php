<?php
require_once 'functions.php';
require_role('admin');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: admin_dashboard.php'); exit; }
$report_id = intval($_POST['report_id']);
$tech_id = intval($_POST['tech_id']);
$mysqli->query("UPDATE reports SET assigned_to={$tech_id}, status='assigned' WHERE id={$report_id}");
header('Location: admin_dashboard.php'); exit;
?>