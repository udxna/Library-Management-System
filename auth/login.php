<?php
// login.php
session_start();

// Database connection
$host = "localhost";
$dbname = "library_system";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = trim($_POST['username'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (empty($uname) || empty($pass)) {
        $error = "Username and password are required.";
    } else {
        // Fetch user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $uname]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ✅ FIXED: Use password_verify() to check against the hashed password in DB
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['userid']    = $user['userid'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname']  = $user['lastname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Modern Login UI</title>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>


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
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            overflow:hidden;
            background:linear-gradient(135deg,#b8f5d3,#dff9ff,#9bd4ff);
            position:relative;
        }

        /* Background Decorative Shapes */

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

        /* Book Rack Design */

        .book-rack{
            position:absolute;
            bottom:0;
            width:100%;
            height:120px;
            background:linear-gradient(to top,#2c3e50,#3f5873);
            display:flex;
            justify-content:center;
            align-items:flex-end;
            gap:10px;
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

        /* Login Card */

        .login-container{
            width:380px;
            padding:40px;
            border-radius:25px;
            background:rgba(255,255,255,0.18);
            backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,0.3);
            box-shadow:
                0 8px 32px rgba(0,0,0,0.15),
                inset 0 0 10px rgba(255,255,255,0.3);
            position:relative;
            z-index:10;
        }

        /* Shine Effect */

        .login-container::before{
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
            background:linear-gradient(135deg,#00c6a7,#0984e3);
            color:white;
            font-size:34px;
            font-weight:bold;
            box-shadow:0 5px 20px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            color:#134b5f;
            margin-bottom:30px;
            font-weight:600;
        }

        .input-box{
            margin-bottom:20px;
        }

        .input-box input{
            width:100%;
            padding:14px;
            border:none;
            outline:none;
            border-radius:12px;
            background:rgba(255,255,255,0.35);
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

        .login-btn{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,#00c9a7,#0984e3);
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        .login-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(0,0,0,0.25);
        }

        .register{
            text-align:center;
            margin-top:20px;
            color:#134b5f;
            font-size:14px;
        }

        .register a{
            text-decoration:none;
            color:#0077ff;
            font-weight:600;
        }

        .register a:hover{
            text-decoration:underline;
        }

    </style>
</head>
<body>

    <!-- Background Shapes -->
    <div class="shape1"></div>
    <div class="shape2"></div>

    <!-- Login Form -->
    <div class="login-container">

        <!-- Logo -->
        <div class="logo">
          <img src="logo.png" width="70">
        </div>

        <h2>Welcome Back</h2>

        <form>

            <div class="input-box">
                <input type="text" placeholder="Enter Username">
            </div>

            <div class="input-box">
                <input type="password" placeholder="Enter Password">
            </div>

            <button class="login-btn">
                Login
            </button>

        </form>

        <div class="register">
            Don’t have an account?
            <a href="#">Register Here</a>
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