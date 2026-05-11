<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update = "UPDATE users SET
    firstname='$firstname',
    lastname='$lastname',
    username='$username',
    email='$email'
    WHERE id='$id'";

    mysqli_query($conn,$update);

    header("Location: view_users.php");
}
?>
<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow p-4">

<h2 class="mb-4">Update User</h2>

<form method="POST">

<div class="mb-3">
<label>First Name</label>
<input type="text" name="firstname" class="form-control" value="<?php echo $row['firstname']; ?>">
</div>

<div class="mb-3">
<label>Last Name</label>
<input type="text" name="lastname" class="form-control" value="<?php echo $row['lastname']; ?>">
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
</div>

<button type="submit" name="update" class="btn btn-success w-100">
Update User
</button>

</form>

</div>
</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>