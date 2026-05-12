<?php
include("../config/db.php");

if(isset($_POST['register'])){

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        echo "Email already exists";

    } else {

        $sql = "INSERT INTO users(fullname, email, password)
                VALUES('$fullname', '$email', '$password')";

        if(mysqli_query($conn, $sql)){
            echo "Registration Successful";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register Form</h2>

<form method="POST">

    <input type="text" name="fullname" placeholder="Full Name" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button type="submit" name="register">Register</button>

</form>

</body>
</html>