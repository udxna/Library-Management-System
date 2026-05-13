<?php
session_start();

require_once '../config/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM `user` ORDER BY user_id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modern LMS Dashboard</title>

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
      overflow-x:hidden;
      background:
        linear-gradient(rgba(6, 35, 51, 0.75),
        rgba(10, 75, 95, 0.80)),
        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2070&auto=format&fit=crop');
      background-size:cover;
      background-position:center;
      background-attachment:fixed;
      position:relative;
    }

    /* Floating Shapes */

    .shape{
      position:absolute;
      opacity:0.12;
      z-index:0;
      animation:float 6s ease-in-out infinite;
    }

    .book1{
      top:120px;
      left:50px;
      font-size:120px;
      color:#9be7c4;
    }

    .book2{
      bottom:80px;
      right:100px;
      font-size:140px;
      color:#64dfdf;
      animation-delay:2s;
    }

    .book3{
      top:300px;
      right:300px;
      font-size:100px;
      color:#80ffdb;
      animation-delay:4s;
    }

    @keyframes float{
      0%{
        transform:translateY(0px);
      }
      50%{
        transform:translateY(-20px);
      }
      100%{
        transform:translateY(0px);
      }
    }

    /* Navbar */

    .navbar{
      background:rgba(8, 25, 40, 0.85) !important;
      backdrop-filter:blur(10px);
      padding:15px 25px;
      box-shadow:0 4px 15px rgba(0,0,0,0.3);
    }

    .navbar-brand{
      color:#fff !important;
      font-size:28px;
      font-weight:700;
      letter-spacing:1px;
    }

    .nav-btn{
      border-radius:12px;
      padding:8px 18px;
      font-weight:500;
      transition:0.3s;
      margin-left:10px;
    }

    .nav-btn:hover{
      transform:translateY(-2px);
    }

    /* Dashboard Wrapper */

    .dashboard-container{
      position:relative;
      z-index:10;
      padding:50px 20px;
    }

    /* Dashboard Card */

    .dashboard-card{
      background:rgba(255,255,255,0.12);
      backdrop-filter:blur(15px);
      border:1px solid rgba(255,255,255,0.2);
      border-radius:25px;
      padding:35px;
      box-shadow:0 8px 32px rgba(0,0,0,0.25);
    }

    /* Title */

    .dashboard-title{
      color:#fff;
      font-size:38px;
      font-weight:700;
      margin-bottom:10px;
    }

    .dashboard-subtitle{
      color:#d8f3dc;
      margin-bottom:30px;
    }

    /* Stats Cards */

    .stat-card{
      border-radius:20px;
      padding:25px;
      color:#fff;
      position:relative;
      overflow:hidden;
      transition:0.3s;
      min-height:150px;
    }

    .stat-card:hover{
      transform:translateY(-5px);
    }

    .stat-card i{
      font-size:45px;
      opacity:0.3;
      position:absolute;
      right:20px;
      bottom:15px;
    }

    .bg-green{
      background:linear-gradient(135deg,#2ecc71,#27ae60);
    }

    .bg-blue{
      background:linear-gradient(135deg,#3498db,#2980b9);
    }

    .bg-teal{
      background:linear-gradient(135deg,#00b4d8,#0077b6);
    }

    .bg-darkblue{
      background:linear-gradient(135deg,#1d3557,#457b9d);
    }

    .stat-number{
      font-size:34px;
      font-weight:700;
    }

    .stat-title{
      font-size:16px;
      margin-top:5px;
    }

    /* Table */

    .table-wrapper{
  margin-top:40px;
  background:rgba(255,255,255,0.14);
  backdrop-filter:blur(18px);
  border:1px solid rgba(255,255,255,0.25);
  border-radius:22px;
  padding:22px;
  box-shadow:0 8px 32px rgba(0,0,0,0.28);
}

.glass-table{
  color:#00FF7F;
  margin-bottom:0;
  border-radius:15px;
  overflow:hidden;
}

.glass-table thead{
  background:rgba(255,255,255,0.22);
  color:#fff;
}

.glass-table thead th{
  border:none;
  padding:16px;
  font-weight:600;
}

.glass-table tbody tr{
  background:rgba(255,255,255,0.10);
  transition:0.3s;
}

.glass-table tbody tr:hover{
  background:rgba(255,255,255,0.22);
}

.glass-table td{
  border-color:rgba(255,255,255,0.12);
  padding:15px;
  vertical-align:middle;
}

.password-cell{
  max-width:300px;
  word-break:break-all;
  font-size:13px;
}

.action-buttons{
  white-space:nowrap;
}

.btn-edit{
  background:linear-gradient(135deg,#ffd60a,#ffb703);
  color:#000;
  border:none;
  border-radius:10px;
  padding:7px 13px;
  font-weight:600;
  margin-right:6px;
}

.btn-delete{
  background:linear-gradient(135deg,#ff4d6d,#c9184a);
  color:#fff;
  border:none;
  border-radius:10px;
  padding:7px 13px;
  font-weight:600;
}

.btn-edit:hover,
.btn-delete:hover{
  transform:translateY(-2px);
  opacity:0.9;
}

    /* Buttons */

    .btn-edit{
      background:#ffd60a;
      color:#000;
      border:none;
      border-radius:5px;
      padding:6px 20px;
      font-weight:500;
    }

    .btn-delete{
      background:#ef233c;
      color:#fff;
      border:none;
      border-radius:5px;
      padding:6px 20px;
      font-weight:500;
    }

    .btn-edit:hover,
    .btn-delete:hover{
      opacity:0.9;
      transform:scale(1.03);
    }

    /* Footer */

    .footer{
      text-align:center;
      color:#cde;
      padding:20px;
      margin-top:30px;
      font-size:14px;
    }

    /* Responsive */

    @media(max-width:768px){

      .dashboard-title{
        font-size:28px;
      }

      .navbar-brand{
        font-size:22px;
      }

      .dashboard-card{
        padding:20px;
      }

      .table{
        min-width:900px;
      }

      .table-wrapper{
        overflow-x:auto;
      }
    }

  </style>
</head>

<body>

  <!-- Floating Library Shapes -->

  <i class="bi bi-book-half shape book1"></i>
  <i class="bi bi-journal-richtext shape book2"></i>
  <i class="bi bi-book shape book3"></i>

  <!-- Navbar -->

  <nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

      <a class="navbar-brand" href="#">
        <i class="bi bi-book-fill"></i> LMS
      </a>

      <div class="d-flex">

        <a href="dashboard.php" class="btn btn-light nav-btn text-decoration-none">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="view_users.php" class="btn btn-warning nav-btn text-decoration-none">
          <i class="bi bi-people-fill"></i> Users
        </a>

        <a href="logout.php" class="btn btn-danger nav-btn text-decoration-none">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>

      </div>

    </div>

  </nav>

  <!-- Dashboard -->

  <div class="container dashboard-container">

    <div class="dashboard-card">

      <h1 class="dashboard-title">
        Virtual Library Dashboard
      </h1>

      <p class="dashboard-subtitle">
        Manage books, users and library records in a modern smart environment.
      </p>

      <!-- Stats -->

      <div class="row g-4">

        <div class="col-md-3">

          <div class="stat-card bg-green">

            <div class="stat-number">1,250</div>
            <div class="stat-title">Books Available</div>

            <i class="bi bi-book-fill"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-blue">

            <div class="stat-number">350</div>
            <div class="stat-title">Active Users</div>

            <i class="bi bi-people-fill"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-teal">

            <div class="stat-number">84</div>
            <div class="stat-title">Books Borrowed</div>

            <i class="bi bi-journal-check"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-darkblue">

            <div class="stat-number">26</div>
            <div class="stat-title">New Arrivals</div>

            <i class="bi bi-stars"></i>

          </div>

        </div>

      </div>

    </div>



    <div class="table-wrapper">
      <h3 class="text-white mb-3"><i class="bi bi-people-fill"></i> Registered Users</h3>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['password']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                  <a class="btn-edit text-decoration-none" href="update_user.php?id=<?php echo urlencode($row['user_id']); ?>">Edit</a>
                  <a class="btn-delete text-decoration-none" href="delete_user.php?id=<?php echo urlencode($row['user_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center">No users found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="footer">
      © 2025 Library Management System 
    </div>

  </div>

</body>
</html>