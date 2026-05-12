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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modern Login</title>

    <!-- Bootstrap 5 -->
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
            height:100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display:flex;
            justify-content:center;
            align-items:center;
            overflow:hidden;
        }

        .login-container{
            width:100%;
            max-width:420px;
            padding:20px;
        }

        .login-card{
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            border:1px solid rgba(255,255,255,0.2);
            border-radius:20px;
            padding:40px 35px;
            box-shadow:0 8px 32px rgba(0,0,0,0.2);
            color:#fff;
        }

        .login-title{
            text-align:center;
            font-size:32px;
            font-weight:700;
            margin-bottom:10px;
        }

        .login-subtitle{
            text-align:center;
            color:#e5e5e5;
            margin-bottom:30px;
            font-size:14px;
        }

        .form-control{
            height:50px;
            border-radius:12px;
            border:none;
            padding-left:45px;
            background:rgba(255,255,255,0.2);
            color:#fff;
        }

        .form-control::placeholder{
            color:#f1f1f1;
        }

        .form-control:focus{
            background:rgba(255,255,255,0.25);
            color:#fff;
            box-shadow:none;
            border:1px solid rgba(255,255,255,0.4);
        }

        .input-group-text{
            background:transparent;
            border:none;
            position:absolute;
            z-index:10;
            height:100%;
            color:#fff;
            padding-left:15px;
        }

        .input-wrapper{
            position:relative;
            margin-bottom:20px;
        }

        .btn-login{
            width:100%;
            height:50px;
            border:none;
            border-radius:12px;
            background:#fff;
            color:#6a11cb;
            font-weight:600;
            transition:0.3s ease;
        }

        .btn-login:hover{
            background:#ececec;
            transform:translateY(-2px);
        }

        .extra-links{
            text-align:center;
            margin-top:20px;
            font-size:14px;
        }

        .extra-links a{
            color:#fff;
            text-decoration:none;
            font-weight:600;
        }

        .extra-links a:hover{
            text-decoration:underline;
        }

        .forgot-password{
            text-align:right;
            margin-bottom:20px;
        }

        .forgot-password a{
            color:#fff;
            text-decoration:none;
            font-size:13px;
        }

        .forgot-password a:hover{
            text-decoration:underline;
        }

        @media(max-width:480px){
            .login-card{
                padding:30px 25px;
            }

            .login-title{
                font-size:28px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">

        <h1 class="login-title">Welcome Back</h1>
        <p class="login-subtitle">Login to continue</p>

        <form>

            <!-- Username -->
            <div class="input-wrapper">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>

                <input type="text"
                       class="form-control"
                       placeholder="Username"
                       required>
            </div>

            <!-- Password -->
            <div class="input-wrapper">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>

                <input type="password"
                       class="form-control"
                       placeholder="Password"
                       required>
            </div>

            <!-- Forgot Password -->
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-login">
                Login
            </button>

        </form>

        <!-- Register -->
        <div class="extra-links">
            Don’t have an account?
            <a href="#">Register here</a>
        </div>

    </div>
</div>

</body>
</html>