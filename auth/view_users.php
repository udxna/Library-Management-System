<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

include '../config/db.php';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn,$sql);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">

<div class="card shadow p-4">

<h2 class="mb-4">User List</h2>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>ID</th>
<th>User ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Username</th>
<th>Email</th>
<th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['firstname']; ?></td>
<td><?php echo $row['lastname']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<a href="update_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
Delete
</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>

<?php include '../includes/footer.php'; ?>
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
      background:rgba(255,255,255,0.08);
      border-radius:20px;
      overflow:hidden;
      padding:20px;
    }

    .table{
      color:#fff;
      margin-bottom:0;
    }

    .table thead{
      background:rgba(0,0,0,0.35);
    }

    .table thead th{
      border:none;
      padding:18px;
      font-weight:600;
    }

    .table tbody tr{
      transition:0.3s;
    }

    .table tbody tr:hover{
      background:rgba(255,255,255,0.08);
    }

    .table td{
      border-color:rgba(255,255,255,0.08);
      padding:16px;
      vertical-align:middle;
    }

    /* Buttons */

    .btn-edit{
      background:#ffd60a;
      color:#000;
      border:none;
      border-radius:10px;
      padding:6px 14px;
      font-weight:500;
    }

    .btn-delete{
      background:#ef233c;
      color:#fff;
      border:none;
      border-radius:10px;
      padding:6px 14px;
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

        <button class="btn btn-light nav-btn">
          <i class="bi bi-speedometer2"></i> Dashboard
        </button>

        <button class="btn btn-warning nav-btn">
          <i class="bi bi-people-fill"></i> Users
        </button>

        <button class="btn btn-danger nav-btn">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>

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

      <!-- User Table -->

      <div class="table-wrapper">

        <h4 class="text-white mb-4">
          <i class="bi bi-person-lines-fill"></i>
          User List
        </h4>

        <table class="table align-middle">

          <thead>

            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>

          </thead>

          <tbody>

            <tr>
              <td>1</td>
              <td>U001</td>
              <td>Chamod</td>
              <td>Nimsara</td>
              <td>Chamod07</td>
              <td>chamod@gmail.com</td>
              <td>
                <button class="btn btn-edit btn-sm">Edit</button>
                <button class="btn btn-delete btn-sm">Delete</button>
              </td>
            </tr>

            <tr>
              <td>2</td>
              <td>U002</td>
              <td>Sithum</td>
              <td>Nimsara</td>
              <td>Sithum25</td>
              <td>sithum@gmail.com</td>
              <td>
                <button class="btn btn-edit btn-sm">Edit</button>
                <button class="btn btn-delete btn-sm">Delete</button>
              </td>
            </tr>

            <tr>
              <td>3</td>
              <td>U003</td>
              <td>Nawodya</td>
              <td>Sathsarani</td>
              <td>Nawodya19</td>
              <td>nawodya@gmail.com</td>
              <td>
                <button class="btn btn-edit btn-sm">Edit</button>
                <button class="btn btn-delete btn-sm">Delete</button>
              </td>
            </tr>

          </tbody>

        </table>

      </div>

    </div>

    <div class="footer">
      © 2025 Library Management System • Modern Virtual Library UI
    </div>

  </div>

</body>
</html>