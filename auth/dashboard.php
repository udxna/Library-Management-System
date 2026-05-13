<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            background:
                    linear-gradient(rgba(7,28,39,0.75), rgba(7,28,39,0.75)),
                    url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1920&auto=format&fit=crop');

            background-size:cover;
            background-position:center;
            background-attachment:fixed;
        }

        /* NAVBAR */

        .navbar{
            background:rgba(255,255,255,0.08)!important;
            backdrop-filter:blur(12px);
            border-bottom:1px solid rgba(255,255,255,0.15);
            padding:15px 30px;
        }

        .navbar-brand{
            color:#fff !important;
            font-size:28px;
            font-weight:700;
        }

        .nav-link-btn{
            text-decoration:none;
            color:#fff;
            padding:10px 18px;
            border-radius:12px;
            font-weight:500;
            transition:0.3s;
            display:inline-block;
        }

        .dashboard-btn{
            background:linear-gradient(45deg,#2bb6ff,#1de9b6);
        }

        .users-btn{
            background:linear-gradient(45deg,#00c6ff,#0072ff);
        }

        .logout-btn{
            background:linear-gradient(45deg,#ff416c,#ff4b2b);
        }

        .nav-link-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(0,0,0,0.25);
            color:#fff;
        }

        /* DASHBOARD */

        .dashboard-wrapper{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:90vh;
            padding:40px 20px;
        }

        .glass-card{
            width:100%;
            max-width:1000px;
            background:rgba(255,255,255,0.12);
            backdrop-filter:blur(16px);
            border:1px solid rgba(255,255,255,0.2);
            border-radius:30px;
            padding:50px;
            box-shadow:0 8px 32px rgba(0,0,0,0.25);
            color:#fff;
            position:relative;
            overflow:hidden;
        }

        .glass-card::before{
            content:'';
            position:absolute;
            width:250px;
            height:250px;
            background:rgba(0,255,200,0.15);
            border-radius:50%;
            top:-80px;
            left:-80px;
        }

        .glass-card::after{
            content:'';
            position:absolute;
            width:220px;
            height:220px;
            background:rgba(0,140,255,0.15);
            border-radius:50%;
            bottom:-90px;
            right:-90px;
        }

        .welcome-title{
            font-size:48px;
            font-weight:700;
            margin-bottom:15px;
        }

        .welcome-user{
            font-size:28px;
            color:#d8fff5;
            margin-bottom:10px;
        }

        .subtitle{
            color:#d9f3ff;
            margin-bottom:40px;
        }

        /* STATS */

        .stat-box{
            background:rgba(255,255,255,0.12);
            border:1px solid rgba(255,255,255,0.15);
            border-radius:20px;
            padding:25px;
            text-align:center;
            transition:0.3s;
            height:100%;
        }

        .stat-box:hover{
            transform:translateY(-5px);
            background:rgba(255,255,255,0.18);
        }

        .stat-icon{
            font-size:35px;
            margin-bottom:15px;
            color:#8fffe3;
        }

        .stat-number{
            font-size:32px;
            font-weight:700;
        }

        .stat-text{
            color:#d8ecff;
        }

        /* ACTION BUTTONS */

        .action-btn{
            text-decoration:none;
            display:inline-block;
            border:none;
            padding:14px 30px;
            border-radius:15px;
            font-size:16px;
            font-weight:600;
            transition:0.3s;
            margin:10px;
            color:#fff;
        }

        .manage-btn{
            background:linear-gradient(45deg,#00c6ff,#0072ff);
            box-shadow:0 8px 20px rgba(0,114,255,0.4);
        }

        .books-btn{
            background:linear-gradient(45deg,#1de9b6,#1dc4e9);
            box-shadow:0 8px 20px rgba(29,233,182,0.4);
        }

        .action-btn:hover{
            transform:translateY(-3px);
            color:#fff;
        }

        @media(max-width:768px){

            .glass-card{
                padding:35px 25px;
            }

            .welcome-title{
                font-size:34px;
            }

            .welcome-user{
                font-size:22px;
            }
     }
         /* Footer */

            .footer{
               text-align:center;
               color:#cde;
               padding:20px;
               margin-top:30px;
               font-size:14px;
         }


    </style>

</head>
<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg">

    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <i class="bi bi-book-half"></i> LMS
        </a>

        <div class="d-flex gap-2">

            <a href="dashboard.php" class="nav-link-btn dashboard-btn">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="view_users.php" class="nav-link-btn users-btn">
                <i class="bi bi-people-fill"></i> Users
            </a>

            <a href="logout.php" class="nav-link-btn logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

        </div>

    </div>

</nav>

<!-- DASHBOARD -->

<section class="dashboard-wrapper">

    <div class="glass-card text-center">

        <h1 class="welcome-title">
            Welcome to Our LMS Dashboard
        </h1>

        <h3 class="welcome-user">
            Hello,
            <?php echo $_SESSION['username']; ?> 👋
        </h3>

        <p class="subtitle">
            Smart Library Management System
        </p>

        <!-- STATS -->

        <div class="row g-4 mb-5">

            <div class="col-md-4">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-book-fill"></i>
                    </div>

                    <div class="stat-number">1500 +</div>

                    <div class="stat-text">
                        Total Books
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div class="stat-number">350 +</div>

                    <div class="stat-text">
                        Active Users
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-journal-check"></i>
                    </div>

                    <div class="stat-number">80 +</div>

                    <div class="stat-text">
                        Borrowed Books
                    </div>

                </div>

            </div>

        </div>

        <!-- BUTTONS -->

        <div>

            <a href="view_users.php" class="action-btn manage-btn">
                <i class="bi bi-person-gear"></i>
                Manage Users
            </a>

           <a href="update_user.php" class="action-btn books-btn">
                <i class="bi bi-book"></i>
                Update User
            </a>

        </div>

        
    </div>

    <div class="footer">
      © 2025 Library Management System | Designed by CG Product Developer
    </div>
 

</section>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>