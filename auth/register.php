<?php
include 'config/db.php';

if(isset($_POST['register'])){

    $userid = $_POST['userid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // USER ID VALIDATION
    if(!preg_match("/^U[0-9]{3}$/", $userid)){
        echo "Invalid User ID Format";
        exit();
    }

    // PASSWORD VALIDATION
    if(strlen($password) < 8){
        echo "Password must be more than 8 characters";
        exit();
    }

    // EMAIL VALIDATION
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid Email";
        exit();
    }

    // HASH PASSWORD
    $hashedPassword = md5($password);

    $sql = "INSERT INTO users 
    (userid, firstname, lastname, username, password, email)
    VALUES
    ('$userid','$firstname','$lastname','$username','$hashedPassword','$email')";

    mysqli_query($conn,$sql);

    echo "Registration Success";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="container mt-5">

<h2>User Registration</h2>

<form method="POST">

<input type="text" name="userid" class="form-control mb-3" placeholder="U001" required>

<input type="text" name="firstname" class="form-control mb-3" placeholder="First Name" required>

<input type="text" name="lastname" class="form-control mb-3" placeholder="Last Name" required>

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<button type="submit" name="register" class="btn btn-primary">
Register
</button>

</form>

</body>
</html>