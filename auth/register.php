<?php
include '../config/db.php';

$message = "";

if(isset($_POST['register'])){

    $userid = trim($_POST['userid']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Validation
    if(!preg_match('/^U[0-9]{3}$/', $userid)){
        $message = "User ID must be like U001";
    }
    elseif(strlen($password) < 8){
        $message = "Password must be at least 8 characters";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Invalid Email Format";
    }
    else{

        // Check existing username/email
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            $message = "Username or Email Already Exists";

        } else {

            // Secure password hash
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert data
            $insert = $conn->prepare("INSERT INTO users(userid, firstname, lastname, username, password, email)
            VALUES(?,?,?,?,?,?)");

            $insert->bind_param(
                "ssssss",
                $userid,
                $firstname,
                $lastname,
                $username,
                $hashedPassword,
                $email
            );

            if($insert->execute()){

                $message = "Registration Successful";

            } else {

                $message = "Registration Failed: " . $conn->error;
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">

<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow p-4">

<h2 class="text-center mb-4">User Registration</h2>

<?php if($message != ""){ ?>
<div class="alert alert-info">
    <?php echo $message; ?>
</div>
<?php } ?>

<form method="POST">

<div class="mb-3">
<label>User ID</label>
<input type="text" name="userid" class="form-control" placeholder="U001" required>
</div>

<div class="mb-3">
<label>First Name</label>
<input type="text" name="firstname" class="form-control" required>
</div>

<div class="mb-3">
<label>Last Name</label>
<input type="text" name="lastname" class="form-control" required>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<button type="submit" name="register" class="btn btn-primary w-100">
Register
</button>

<div class="text-center mt-3">
<a href="login.php">Already have an account?</a>
</div>

</form>

</div>
</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>