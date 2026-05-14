<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && $_GET['id'] !== '') {

    $user_id = $_GET['id'];

    // Delete selected user
    $stmt = mysqli_prepare($conn, "DELETE FROM `user` WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);

    // Re-arrange User IDs again: U001, U002, U003...
    $sql = "SELECT user_id FROM `user` ORDER BY CAST(SUBSTRING(user_id, 2) AS UNSIGNED) ASC";
    $result = mysqli_query($conn, $sql);

    $number = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $old_id = $row['user_id'];
        $new_id = "U" . str_pad($number, 3, "0", STR_PAD_LEFT);

        $update = mysqli_prepare($conn, "UPDATE `user` SET user_id = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($update, "ss", $new_id, $old_id);
        mysqli_stmt_execute($update);

        $number++;
    }
}

header("Location: view_users.php");
exit();
?>