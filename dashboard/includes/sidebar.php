<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>LMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f6f9;
            font-family:Arial, sans-serif;
            overflow-x:hidden;
        }

        /* Sidebar */

        .sidebar{
            position:fixed;
            top:0;
            left:0;
            width:250px;
            height:100vh;
            background:#212529;
            padding-top:20px;
            transition:0.3s;
            z-index:1000;
            overflow:hidden;
            display:flex;
            flex-direction:column;
        }

        .sidebar.collapsed{
            width:80px;
        }

        .sidebar h3{
            color:white;
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:10px;
            color:white;
            text-decoration:none;
            padding:14px 20px;
            margin:5px 10px;
            border-radius:10px;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:#0d6efd;
        }

        .sidebar i{
            font-size:20px;
            min-width:25px;
            text-align:center;
        }

        /* Collapse */

        .sidebar.collapsed span{
            display:none;
        }

        .sidebar.collapsed a{
            justify-content:center;
        }

        .sidebar.collapsed h3{
            display:none;
        }

        .sidebar.collapsed img{
            width:45px;
        }

        .sidebar.collapsed h6{
            display:none;
        }

        /* Main Content */

        .main-content{
            margin-left:250px;
            padding:20px;
            transition:0.3s;
        }

        .main-content.expanded{
            margin-left:80px;
        }

        /* Topbar */

        .topbar{
            background:white;
            border-radius:15px;
            padding:15px 20px;
            margin-bottom:25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .toggle-btn{
            border:none;
            background:none;
            font-size:24px;
        }

        /* Dark Mode */

        .dark-mode{
            background:#121212;
            color:white;
        }

        .dark-mode .topbar{
            background:#1f1f1f;
            color:white;
        }

        .dark-mode .card{
            background:#1f1f1f;
            color:white;
        }

        .dark-mode table{
            color:white;
        }

    </style>

</head>

<body>

<!-- Sidebar -->

<div class="sidebar" id="sidebar">

    <!-- Toggle Button -->

    <div class="d-flex justify-content-end px-3 mb-3">

        <button class="btn btn-primary rounded-3"
                onclick="toggleSidebar()">

            <i class="bi bi-list"></i>

        </button>

    </div>

    <!-- Logo -->

    <h3>
        LMS
    </h3>

    <!-- Menu -->

    <a href="../dashboard/index.php">

        <i class="bi bi-speedometer2"></i>

        <span>Dashboard</span>

    </a>
    <a href="../auth/view_users.php">

    <i class="bi bi-person-badge-fill"></i>

    <span>Users</span>

    </a>
    <a href="../members/view.php">

        <i class="bi bi-people-fill"></i>

        <span>Members</span>

    </a>

    <a href="../books/.php">

        <i class="bi bi-book-fill"></i>

        <span>Books</span>

    </a>

    <a href="../categories/book_category.php">

        <i class="bi bi-tags-fill"></i>

        <span>Categories</span>

    </a>

    <a href="../borrow/view.php">

        <i class="bi bi-journal-arrow-down"></i>

        <span>Borrow</span>

    </a>

    <a href="../fines/view.php">

        <i class="bi bi-cash-stack"></i>

        <span>Fines</span>

    </a>
    <!-- Logout Button -->

    <div class="position-absolute bottom-0 start-0 w-100 p-3">

        <a href="../auth/logout.php"
            class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 rounded-3">

            <i class="bi bi-box-arrow-right"></i>

            <span>Logout</span>

        </a>

    </div>
    <!-- Profile -->

    <div class="text-center text-white mt-4">

        <img src="../assets/images/logo.png"
             width="70"
             class="rounded-circle mb-2">

        <h6>
            Welcome Admin
        </h6>

    </div>

</div>



<script>

function toggleSidebar(){

    document
        .getElementById("sidebar")
        .classList.toggle("collapsed");

    document
        .getElementById("mainContent")
        .classList.toggle("expanded");

}

</script>

</body>
</html>
