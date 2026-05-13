<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $user_id = $_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM `user` WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
}

header("Location: view_users.php");
exit();
?>