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
    margin-top: 40px;
    padding: 25px;

    background: rgba(0, 255, 170, 0.12);

    backdrop-filter: blur(18px);

    border: 1px solid rgba(255,255,255,0.15);

    border-radius: 24px;

    box-shadow: 0 8px 35px rgba(0,0,0,0.35);
}

.glass-table{
    width: 500%;

    border-collapse: collapse;

    overflow: hidden;

    border-radius: 18px;

    background: rgba(255,255,255,0.08);

    color: white;
}


.glass-table thead{
    background: linear-gradient(135deg,#00c896,#00e5a8);
}
.glass-table thead th{
    padding: 18px;

    color: white;

    font-size: 18px;

    font-weight: bold;

    text-align: center;

    border-bottom: 1px solid rgba(255,255,255,0.2);
}


.glass-table tbody tr{
    transition: 0.3s ease;
}

.glass-table tbody tr:nth-child(even){
    background: rgba(255,255,255,0.06);
}

.glass-table tbody tr:nth-child(odd){
    background: rgba(255,255,255,0.12);
}

.glass-table tbody tr:hover{
    background: rgba(0,255,170,0.18);

    transform: scale(1.005);
}

.glass-table td{
    padding: 18px;

    text-align: center;

    color: white;

    font-size: 16px;

    font-weight: 600;

    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.password-cell{
    max-width: 350px;

    word-break: break-all;

    font-size: 13px;

    color: #eafff7;
}
.action-buttons{
    display: flex;

    justify-content: center;

    gap: 10px;
}
.btn-edit{
    background: linear-gradient(135deg,#00b4ff,#4cc9f0);

    color: white;

    border: none;

    border-radius: 12px;

    padding: 10px 22px;

    font-size: 15px;

    font-weight: bold;

    text-decoration: none;

    min-width: 95px;

    text-align: center;

    box-shadow: 0 4px 15px rgba(0,180,255,0.35);

    transition: 0.3s ease;
}

.btn-edit:hover{
    transform: translateY(-2px);

    background: linear-gradient(135deg,#0096ff,#00c6ff);

    color: white;
}
.btn-delete{
    background: linear-gradient(135deg,#daa520,#ffd700);

    color: white;

    border: none;

    border-radius: 12px;

    padding: 10px 22px;

    font-size: 15px;

    font-weight: bold;

    text-decoration: none;

    min-width: 95px;

    text-align: center;

    box-shadow: 0 4px 15px rgba(255,215,0,0.35);

    transition: 0.3s ease;
}
.table-title{
    color: white;

    font-size: 34px;

    font-weight: bold;

    margin-bottom: 25px;

    text-shadow: 0 2px 10px rgba(0,0,0,0.35);
}
.user-table-box{
  width: 100%;
  margin-top: 20px;
  border-radius: 18px;
  overflow-x: auto;
  border: 2px solid rgba(255,255,255,0.35);
  box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}

.user-table{
  width: 100%;
  min-width: 1180px;
  margin-bottom: 0;
  border-collapse: collapse;
  background: rgba(255,255,255,0.96);
}

.user-table th,
.user-table td{
  text-align: center;
  vertical-align: middle;
  padding: 16px 14px;
  border: 1px solid #d6d6d6;
  font-weight: 600;
}

.user-table thead th{
  background: linear-gradient(135deg, #00c896, #00e5a8);
  color: white;
  font-weight: 800;
  font-size: 16px;
}

.user-table tbody td{
  color: #111;
  font-size: 15px;
}

.user-table tbody tr:hover{
  background: #2b53c483;
}

.password-col{
  max-width: 430px;
  word-break: break-all;
  font-size: 13px !important;
}

.action-btn-group{
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  flex-wrap: nowrap;
}

.btn-edit,
.btn-delete{
  width: 50px;
  height: 30px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 800;
  color: white;
}

.btn-edit{
  background: linear-gradient(135deg, #00b4ff, #4cc9f0);
}

.btn-delete{
  background: linear-gradient(135deg, #daa520, #ffd700);
}

.btn-edit:hover,
.btn-delete:hover{
  color: white;
  transform: translateY(-2px);
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

            <div class="stat-number">1,500 +</div>
            <div class="stat-title">Books Available</div>

            <i class="bi bi-book-fill"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-blue">

            <div class="stat-number">350 +</div>
            <div class="stat-title">Active Users</div>

            <i class="bi bi-people-fill"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-teal">

            <div class="stat-number">80 +</div>
            <div class="stat-title">Books Borrowed</div>

            <i class="bi bi-journal-check"></i>

          </div>

        </div>

        <div class="col-md-3">

          <div class="stat-card bg-darkblue">

            <div class="stat-number">40 +</div>
            <div class="stat-title">New Arrivals</div>

            <i class="bi bi-stars"></i>

          </div>

        </div>

      </div>

    </div>



  <div class="table-responsive user-table-box">
   <table class="table user-table">
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

        <tr>
          <td colspan="7" class="text-center">No users found</td>
        </tr>
      <?php endif; ?>
    </tbody>
   </table>
  </div>
    <div class="footer">
      © 2026 Library Management System | Designed by CG Product Developer | All Rights Reserved
    </div>

  </div>

</body>
</html>