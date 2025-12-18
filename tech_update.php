<?php
require_once 'functions.php';
require_role('technician');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: technician_dashboard.php'); exit; }
$report_id = intval($_POST['report_id']);
$action = $_POST['action'];
$tech_name = $mysqli->real_escape_string($_POST['tech_name']);
$tech_note = $mysqli->real_escape_string($_POST['tech_note']);
if ($action === 'start') {
    $mysqli->query("UPDATE reports SET status='in_progress', tech_name='{$tech_name}', tech_note='{$tech_note}' WHERE id={$report_id}");
} elseif ($action === 'finish') {
    $mysqli->query("UPDATE reports SET status='resolved', tech_name='{$tech_name}', tech_note='{$tech_note}' WHERE id={$report_id}");
}
header('Location: technician_dashboard.php'); exit;
?>