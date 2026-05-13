<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || $_GET['id'] === '') {
    header("Location: view_users.php");
    exit();
}

$user_id = $_GET['id'];
$error = "";

$stmt = mysqli_prepare($conn, "SELECT * FROM `user` WHERE user_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header("Location: view_users.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');

    if ($firstname === '' || $lastname === '' || $username === '' || $email === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $check = mysqli_prepare($conn, "SELECT user_id FROM `user` WHERE (username = ? OR email = ?) AND user_id != ? LIMIT 1");
        mysqli_stmt_bind_param($check, "sss", $username, $email, $user_id);
        mysqli_stmt_execute($check);
        $checkResult = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "Username or Email already exists.";
        } else {
            $update = mysqli_prepare($conn, "UPDATE `user` SET first_name = ?, last_name = ?, username = ?, email = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($update, "sssss", $firstname, $lastname, $username, $email, $user_id);
            mysqli_stmt_execute($update);
            header("Location: view_users.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    linear-gradient(rgba(6,35,51,0.75), rgba(10,75,95,0.80)),
    url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2070&auto=format&fit=crop');
    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

.navbar{
    background:rgba(8,25,40,0.90);
    padding:15px 25px;
}

.navbar-brand{
    color:#fff;
    font-size:28px;
    font-weight:700;
}

.nav-btn{
    border-radius:12px;
    padding:8px 18px;
    font-weight:500;
    margin-left:10px;
}

.update-container{
    padding:80px 20px;
}

.update-card{
    max-width:650px;
    margin:auto;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:25px;
    padding:40px;
    box-shadow:0 8px 32px rgba(0,0,0,0.25);
}

.update-card h2{
    color:#fff;
    font-weight:700;
    margin-bottom:10px;
}

.update-card p{
    color:#d8f3dc;
    margin-bottom:30px;
}

.form-label{
    color:#fff;
    font-weight:500;
}

.form-control{
    padding:14px;
    border-radius:12px;
    border:none;
    margin-bottom:18px;
}

.form-control:focus{
    box-shadow:0 0 12px rgba(0,200,255,0.5);
}

.btn-update{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(130deg,#00c9a7,#0984e3);
    color:white;
    font-size:16px;
    font-weight:600;
}

.btn-back{
    width:100%;
    padding:12px;
    margin-top:12px;
    border-radius:12px;
    font-weight:600;
}
</style>
</head>

<body>

<nav class="navbar d-flex justify-content-between">
    <a class="navbar-brand" href="dashboard.php">
        <i class="bi bi-book-fill"></i> LMS
    </a>

    <div>
        <a href="dashboard.php" class="btn btn-light nav-btn">Dashboard</a>
        <a href="view_users.php" class="btn btn-warning nav-btn">Users</a>
        <a href="logout.php" class="btn btn-danger nav-btn">Logout</a>
    </div>
</nav>

<div class="update-container">

    <div class="update-card">

        <h2><i class="bi bi-pencil-square"></i> Update User</h2>
        <p>Edit user details using the LMS dashboard theme.</p>

        <?php if($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <form method="POST">

            <label class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control"
                   value="<?php echo htmlspecialchars($row['first_name']); ?>" required>

            <label class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control"
                   value="<?php echo htmlspecialchars($row['last_name']); ?>" required>

            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?php echo htmlspecialchars($row['username']); ?>" required>

            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?php echo htmlspecialchars($row['email']); ?>" required>

            <button type="submit" name="update" class="btn-update">
                Update User
            </button>

            <a href="view_users.php" class="btn btn-light btn-back">
                Back to Users
            </a>

        </form>

    </div>

</div>

</body>
</html>