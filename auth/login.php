<?php
$theme-colors: (
  "primary":    $primary,
  "secondary":  $secondary,
  "success":    $success,
  "info":       $info,
  "warning":    $warning,
  "danger":     $danger,
  "light":      $light,
  "dark":       $dark
);
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