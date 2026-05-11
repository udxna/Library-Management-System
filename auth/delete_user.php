<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";

mysqli_query($conn,$sql);

header("Location: view_users.php");
?>