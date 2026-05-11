<?php
session_start();
include 'config/db.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users 
    WHERE username='$username' 
    AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['username'] = $username;

        header("Location: dashboard.php");

    }else{
        echo "Login Failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="container mt-5">

<h2>Login</h2>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username">

<input type="password" name="password" class="form-control mb-3" placeholder="Password">

<button class="btn btn-success" name="login">
Login
</button>

</form>

</body>
</html>