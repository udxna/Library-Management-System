<?php
session_start();
require_once '../config/db.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid    = trim($_POST['userid'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    if ($userid === '' || $firstname === '' || $lastname === '' || $username === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } elseif (!preg_match('/^U[0-9]{3}$/', $userid)) {
        $error = "User ID must be like U001.";
    } elseif (strlen($password) <= 8) {
        $error = "Password must be more than 8 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // IMPORTANT: table name is `user`; column name is user_id
        $check = mysqli_prepare($conn, "SELECT user_id FROM `user` WHERE user_id = ? OR username = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($check, "sss", $userid, $username, $email);
        mysqli_stmt_execute($check);
        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {
            $error = "User ID, Username or Email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO `user` (user_id, email, first_name, last_name, username, password) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssss", $userid, $email, $firstname, $lastname, $username, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Registration Successful! Now you can login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LMS Registeration</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            overflow:hidden;
            background:linear-gradient(135deg,#b8f5d3,#dff9ff,#9bd4ff);
            position:relative;
            padding:20px;
        }

        /* Background Shapes */

        .shape1{
            position:absolute;
            width:350px;
            height:350px;
            background:rgba(255,255,255,0.25);
            border-radius:50%;
            top:-100px;
            left:-80px;
            filter:blur(10px);
        }

        .shape2{
            position:absolute;
            width:280px;
            height:280px;
            background:rgba(0,140,255,0.15);
            border-radius:50%;
            bottom:-100px;
            right:-50px;
            filter:blur(10px);
        }

        /* Book Rack */

        .book-rack{
            position:absolute;
            bottom:0;
            width:100%;
            height:120px;
            background:linear-gradient(to top,#2c3e50,#3f5873);
            display:flex;
            justify-content:center;
            align-items:flex-end;
            gap:5px;
            padding-bottom:10px;
        }

        .book{
            width:45px;
            border-radius:6px 6px 0 0;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        .book:nth-child(1){
            height:90px;
            background:#00b894;
        }

        .book:nth-child(2){
            height:70px;
            background:#0984e3;
        }

        .book:nth-child(3){
            height:100px;
            background:#6c5ce7;
        }

        .book:nth-child(4){
            height:80px;
            background:#00cec9;
        }

        .book:nth-child(5){
            height:95px;
            background:#74b9ff;
        }

        /* Register Card */

        .register-container{
            width:750px;
            padding:60px;
            border-radius:25px;
            background:rgba(255,255,255,0.18);
            backdrop-filter:blur(18px);
            border:1px solid rgba(15, 85, 189, 0.3);
            box-shadow:
                0 8px 32px rgba(0,0,0,0.15),
                inset 0 0 10px rgba(255,255,255,0.3);
            position:center;
            z-index:10;
        }

        /* Shine Animation */

        .register-container::before{
            content:'';
            position:absolute;
            top:0;
            left:-75%;
            width:50%;
            height:100%;
            background:linear-gradient(
                120deg,
                rgba(255,255,255,0.1),
                rgba(255,255,255,0.5),
                rgba(255,255,255,0.1)
            );
            transform:skewX(-25deg);
            animation:shine 5s infinite;
        }

        @keyframes shine{
            0%{
                left:-75%;
            }
            100%{
                left:150%;
            }
        }

        /* Logo */

        .logo{
            width:90px;
            height:90px;
            margin:0 auto 15px;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius:50%;
            background:linear-gradient(120deg,#00c6a7,#0984e3);
            color:white;
            font-size:34px;
            font-weight:bold;
            box-shadow:0 5px 20px rgba(81, 235, 107, 0.9);
            overflow:hidden;
        }

        .logo img{
            width:70px;
        }

        h2{
            text-align:center;
            color:#134b5f;
            margin-bottom:25px;
            font-weight:600;
        }

        .input-box{
            margin-bottom:15px;
        }

        .input-box input{
            width:100%;
            padding:14px;
            border:none;
            outline:none;
            border-radius:12px;
            background:rgba(14, 199, 69, 0.35);
            color:#134b5f;
            font-size:15px;
            transition:0.3s;
            box-shadow:inset 0 0 5px rgba(255,255,255,0.3);
        }

        .input-box input::placeholder{
            color:#3b6b75;
        }

        .input-box input:focus{
            transform:scale(1.02);
            background:white;
            box-shadow:0 0 10px rgba(0,150,255,0.4);
        }

        .register-btn{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:linear-gradient(130deg,#00c9a7,#0984e3);
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-top:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        .register-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(0,0,0,0.25);
        }

        .login-link{
            text-align:center;
            margin-top:20px;
            color:#134b5f;
            font-size:14px;
        }

        .login-link a{
            text-decoration:none;
            color:#0077ff;
            font-weight:600;
        }

        .login-link a:hover{
            text-decoration:underline;
        }

        /* Message */

        .success-msg{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:10px;
            margin-bottom:15px;
            text-align:center;
        }

        .error-msg{
            background:#ffdddd;
            color:#c0392b;
            padding:12px;
            border-radius:10px;
            margin-bottom:15px;
            text-align:center;
        }

    </style>

</head>
<body>

    <!-- Background Shapes -->
    <div class="shape1"></div>
    <div class="shape2"></div>

    <!-- Register Form -->
    <div class="register-container">

        <!-- Logo -->
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>

        <h2>Create Account</h2>

        <!-- Success Message -->
        <?php if($message): ?>
            <div class="success-msg">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if($error): ?>
            <div class="error-msg">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="input-box">
                <input type="text" name="userid" placeholder="User ID" required>
            </div>

            <div class="input-box">
                <input type="text" name="firstname" placeholder="First Name" required>
            </div>

            <div class="input-box">
                <input type="text" name="lastname" placeholder="Last Name" required>
            </div>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="register-btn">
                Register
            </button>

        </form>

        <div class="login-link">
            Already have an account?
            <a href="login.php">Login Here</a>
        </div>

    </div>

    <!-- Book Rack -->
    <div class="book-rack">
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
    </div>

</body>
</html>