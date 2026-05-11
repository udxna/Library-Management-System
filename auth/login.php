<?php
session_start();
include '../config/db.php';

$message = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['userid'] = $user['userid'];
        $_SESSION['username'] = $user['username'];

        header("Location: dashboard.php");
    }
    else{
        $message = "Invalid Username or Password";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow p-4">

<h2 class="text-center mb-4">Login</h2>

<?php if($message != ""){ ?>
<div class="alert alert-danger"><?php echo $message; ?></div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="login" class="btn btn-success w-100">
Login
</button>

<div class="text-center mt-3">
<a href="register.php">Create Account</a>
</div>

</form>

</div>
</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
<!-- login.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LMS Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS File -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5">

            <div class="card login-card shadow-lg">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4 login-title">
                        LMS Login
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Welcome Back 📚
                    </p>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input 
                                type="text" 
                                name="username"
                                class="form-control custom-input"
                                placeholder="Enter Username"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input 
                                type="password"
                                name="password"
                                class="form-control custom-input"
                                placeholder="Enter Password"
                                required
                            >

                        </div>

                        <button type="submit" class="btn login-btn w-100">

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a href="register.php" class="register-link">
                            Create New Account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>