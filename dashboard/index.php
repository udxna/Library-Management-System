<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/db.php");

/* Default Values */

$totalMembers = 0;
$totalBooks = 0;
$totalBorrow = 0;
$totalFines = 0;

/* Total Members */

$checkMember = $conn->query("SHOW TABLES LIKE 'member'");

if($checkMember->num_rows > 0){

    $members = $conn->query("SELECT * FROM member");

    if($members){

        $totalMembers = $members->num_rows;

    }

}

/* Total Books */

$checkBook = $conn->query("SHOW TABLES LIKE 'book'");

if($checkBook->num_rows > 0){

    $books = $conn->query("SELECT * FROM book");

    if($books){

        $totalBooks = $books->num_rows;

    }

}

/* Total Borrow */

$checkBorrow = $conn->query("SHOW TABLES LIKE 'borrow'");

if($checkBorrow->num_rows > 0){

    $borrow = $conn->query("SELECT * FROM borrow");

    if($borrow){

        $totalBorrow = $borrow->num_rows;

    }

}

/* Total Fines */

$checkFines = $conn->query("SHOW TABLES LIKE 'fines'");

if($checkFines->num_rows > 0){

    $fines = $conn->query("SELECT * FROM fines");

    if($fines){

        $totalFines = $fines->num_rows;

    }

}

?>
<style>
    .dashboard-hover{
    transition:0.3s;
    cursor:pointer;
}

.dashboard-hover:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.2) !important;
}
</style>

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

</head>

<body>

<?php include("includes/global.php"); ?>

<?php include("../dashboard/includes/sidebar.php"); ?>

<div class="main-content" id="mainContent">

<?php include("../dashboard/includes/navbar.php"); ?>

<h1 class="fw-bold mb-4">
    Dashboard
</h1>

<!-- Dashboard Cards -->

<div class="row g-4 mb-4">

    <!-- Members -->

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

    <!-- Books -->

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

    <!-- Borrow -->

    <div class="col-md-3">

        <a href="../borrow/view.php"
        class="text-decoration-none text-dark">

        <div class="card shadow border-0 p-4 text-center dashboard-hover">

            <h1 class="text-warning">

                <i class="bi bi-journal-check"></i>

            </h1>

            <h2>
                <?php echo $totalBorrow; ?>
            </h2>

            <p class="mb-0">
                Borrowed Books
            </p>

        </div>
        </a>
    </div>

    <!-- Fines -->

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
                Total Fines
            </p>

        </div>
        </a>
    </div>

</div>

<!-- Quick Actions + Recent Activity -->

<div class="row g-4 mb-4">

    <!-- Quick Actions -->

    <div class="col-md-4">

        <div class="card shadow border-0 p-4 h-100">

            <h4 class="mb-4">
                Quick Actions
            </h4>

            <div class="d-grid gap-3">

                <a href="../members/add.php"
                   class="btn btn-primary">

                    <i class="bi bi-person-plus-fill"></i>

                    Add Member

                </a>

                <a href="../books/add.php"
                   class="btn btn-success">

                    <i class="bi bi-book-fill"></i>

                    Add Book

                </a>

                <a href="../categories/book_category.php"
                   class="btn btn-warning text-dark">

                    <i class="bi bi-tags-fill"></i>

                    Add Category

                </a>

            </div>

        </div>

    </div>

    <!-- Recent Activity -->

    <div class="col-md-8">

        <div class="card shadow border-0 p-4">

            <h4 class="mb-4">
                Recent Activity
            </h4>

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>
                            Member
                        </th>

                        <th>
                            Action
                        </th>

                        <th>
                            Birthday
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $recentMembers = $conn->query("
                    SELECT * FROM member
                    ORDER BY member_id DESC
                    LIMIT 5
                ");

                if($recentMembers && $recentMembers->num_rows > 0){

                    while($row = $recentMembers->fetch_assoc()){

                        echo "

                        <tr>

                            <td>

                                ".$row['first_name']." ".$row['last_name']."

                            </td>

                            <td>

                                Registered

                            </td>

                            <td>

                                ".$row['birthday']."

                            </td>

                        </tr>

                        ";

                    }

                } else {

                    echo "

                    <tr>

                        <td colspan='3'
                            class='text-center'>

                            No Recent Activity

                        </td>

                    </tr>

                    ";

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- System Information -->

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>