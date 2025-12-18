<?php
require_once 'config.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function current_user() {
    global $mysqli;
    if (!is_logged_in()) return null;
    $id = intval($_SESSION['user_id']);
    $res = $mysqli->query("SELECT id,username,fullname,role FROM users WHERE id={$id}");
    return $res ? $res->fetch_assoc() : null;
}

function require_role($roles = []) {
    $user = current_user();
    if (!$user || !in_array($user['role'], (array)$roles)) {
        header('Location: index.php');
        exit;
    }
}
?>