<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/db.php");

/* TOTAL MEMBERS */

$totalMembers = 0;

$members = $conn->query("
SELECT COUNT(*) AS total
FROM member
");

if($members){

    $row = $members->fetch_assoc();

    $totalMembers = $row['total'];

}

/* TOTAL BOOKS */

$totalBooks = 0;

$books = $conn->query("
SELECT COUNT(*) AS total
FROM book
");

if($books){

    $row = $books->fetch_assoc();

    $totalBooks = $row['total'];

}

/* BORROWED BOOKS */

$totalBorrowed = 0;

$borrowed = $conn->query("
SELECT COUNT(*) AS total
FROM bookborrower
WHERE borrow_status='Borrowed'
");

if($borrowed){

    $row = $borrowed->fetch_assoc();

    $totalBorrowed = $row['total'];

}

/* AVAILABLE BOOKS */

$availableBooks = $totalBooks - $totalBorrowed;

/* UNPAID FINES */

$totalFines = 0;

$fines = $conn->query("
SELECT COUNT(*) AS total
FROM fine
WHERE status='Unpaid'
");

if($fines){

    $row = $fines->fetch_assoc();

    $totalFines = $row['total'];

}

/* TOTAL CATEGORIES */

$totalCategories = 0;

$categories = $conn->query("
SELECT COUNT(*) AS total
FROM bookcategory
");

if($categories){

    $row = $categories->fetch_assoc();

    $totalCategories = $row['total'];

}

/* PAID FINES */

$paidFines = 0;

$paid = $conn->query("
SELECT COUNT(*) AS total
FROM fine
WHERE status='Paid'
");

if($paid){

    $row = $paid->fetch_assoc();

    $paidFines = $row['total'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    overflow-x:hidden;
    background:#f4f6f9;
}

.main-content{
    margin-left:250px;
    padding:20px;
}

.content-wrapper{
    margin-top:90px;
}

.dashboard-hover{
    transition:0.3s;
    cursor:pointer;
}

.dashboard-hover:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.2) !important;
}

</style>

</head>

<body>

<?php include("includes/global.php"); ?>

<?php include("../dashboard/includes/sidebar.php"); ?>

<div class="main-content" id="mainContent">

<?php include("../dashboard/includes/navbar.php"); ?>

<div class="content-wrapper">

<h1 class="fw-bold mb-4">

Dashboard

</h1>

<!-- FIRST ROW -->

<div class="row g-4 mb-4">

<!-- MEMBERS -->

<div class="col-md-3">

<a href="../members/view.php"
class="text-decoration-none text-dark">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-primary">

<i class="bi bi-people-fill"></i>

</h1>

<h2>

<?php echo $totalMembers; ?>

</h2>

<p class="mb-0">

Total Members

</p>

</div>

</a>

</div>

<!-- BOOKS -->

<div class="col-md-3">

<a href="../books/view.php"
class="text-decoration-none text-dark">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-success">

<i class="bi bi-book-fill"></i>

</h1>

<h2>

<?php echo $totalBooks; ?>

</h2>

<p class="mb-0">

Total Books

</p>

</div>

</a>

</div>

<!-- BORROWED -->

<div class="col-md-3">

<a href="../borrow/borrow.php"
class="text-decoration-none text-dark">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-warning">

<i class="bi bi-journal-check"></i>

</h1>

<h2>

<?php echo $totalBorrowed; ?>

</h2>

<p class="mb-0">

Borrowed Books

</p>

</div>

</a>

</div>

<!-- UNPAID FINES -->

<div class="col-md-3">

<a href="../fines/view.php"
class="text-decoration-none text-dark">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-danger">

<i class="bi bi-cash-stack"></i>

</h1>

<h2>

<?php echo $totalFines; ?>

</h2>

<p class="mb-0">

Unpaid Fines

</p>

</div>

</a>

</div>

</div>

<!-- SECOND ROW -->

<div class="row g-4 mb-4">

<!-- AVAILABLE BOOKS -->

<div class="col-md-4">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-success">

<i class="bi bi-check-circle-fill"></i>

</h1>

<h2>

<?php echo $availableBooks; ?>

</h2>

<p class="mb-0">

Available Books

</p>

</div>

</div>

<!-- CATEGORIES -->

<div class="col-md-4">

<a href="../categories/book_category.php"
class="text-decoration-none text-dark">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-warning">

<i class="bi bi-tags-fill"></i>

</h1>

<h2>

<?php echo $totalCategories; ?>

</h2>

<p class="mb-0">

Book Categories

</p>

</div>

</a>

</div>
<!-- PAID FINES -->

<div class="col-md-4">

<div class="card shadow border-0 p-4 text-center dashboard-hover">

<h1 class="text-primary">

<i class="bi bi-cash-coin"></i>

</h1>

<h2>

<?php echo $paidFines; ?>

</h2>

<p class="mb-0">

Paid Fines

</p>

</div>

</div>

</div>

<!-- RECENT BORROW ACTIVITY -->

<div class="card shadow border-0 p-4 mb-4">

<h4 class="mb-4">

Recent Borrow Activity

</h4>

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>Book ID</th>
<th>Member ID</th>
<th>Borrow Date</th>
<th>Due Date</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$recent = $conn->query("
SELECT *
FROM bookborrower
ORDER BY borrow_date DESC
LIMIT 5
");

if($recent && $recent->num_rows > 0){

while($row = $recent->fetch_assoc()){

?>

<tr>

<td>

<?php echo $row['book_id']; ?>

</td>

<td>

<?php echo $row['member_id']; ?>

</td>

<td>

<?php echo $row['borrow_date']; ?>

</td>

<td>

<?php echo $row['due_date']; ?>

</td>

<td>

<?php echo $row['borrow_status']; ?>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="5"
class="text-center">

No Recent Activity

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- SYSTEM INFO -->

<div class="card shadow border-0 p-4">

<h4 class="mb-4">

System Information

</h4>

<div class="row">

<div class="col-md-4">

<p>

<strong>

PHP Version:

</strong>

<?php echo phpversion(); ?>

</p>

</div>

<div class="col-md-4">

<p>

<strong>

Server:

</strong>

Apache

</p>

</div>

<div class="col-md-4">

<p>

<strong>

Database:

</strong>

MySQL

</p>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>