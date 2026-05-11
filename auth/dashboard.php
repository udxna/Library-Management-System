<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">

<div class="card shadow p-5 text-center">

<h1>Welcome to LMS Dashboard</h1>

<h3 class="mt-3">
Hello, <?php echo $_SESSION['username']; ?> 👋
</h3>

<p class="mt-3">Library Management System - Feature 1</p>

<a href="view_users.php" class="btn btn-primary mt-3">
Manage Users
</a>

</div>

</div>

<?php include '../includes/footer.php'; ?>