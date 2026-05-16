<?php

include("../config/db.php");

$message = "";

/* AUTO GENERATE USER ID */

function generateUserID($conn){

    $query = "
    SELECT user_id
    FROM users
    ORDER BY user_id DESC
    LIMIT 1
    ";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $lastID = $row['user_id'];

        $number = (int)substr($lastID, 1);

        $newNumber = $number + 1;

        return "U" . str_pad(
            $newNumber,
            3,
            "0",
            STR_PAD_LEFT
        );

    } else {

        return "U001";

    }

}

/* ADD USER */

if(isset($_POST['submit'])){

    $user_id = $_POST['user_id'];

    $firstname = $_POST['firstname'];

    $lastname = $_POST['lastname'];

    $email = $_POST['email'];

    $username = $_POST['username'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $role = $_POST['role'];

    /* CHECK USERNAME */

    $check = $conn->prepare("
    SELECT username
    FROM users
    WHERE username=?
    ");

    $check->bind_param("s", $username);

    $check->execute();

    $check->store_result();

    if($check->num_rows > 0){

        $message = "
        <div class='alert alert-danger'>

        Username already exists!

        </div>
        ";

    } else {

        $stmt = $conn->prepare("
        INSERT INTO users
        (
            user_id,
            email,
            firstname,
            lastname,
            username,
            password,
            role
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssss",
            $user_id,
            $email,
            $firstname,
            $lastname,
            $username,
            $password,
            $role
        );

        if($stmt->execute()){

            echo "

            <script>

            alert('User added successfully!');

            window.location='users.php';

            </script>

            ";

            exit();

        } else {

            $message = "
            <div class='alert alert-danger'>

            Failed to create user!

            </div>
            ";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Add User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    overflow-x:hidden;
}

.main-content{
    margin-left:250px;
    padding:20px;
}

.content-wrapper{
    margin-top:100px;
}

</style>

</head>

<body>

<?php include("../dashboard/includes/sidebar.php"); ?>

<div class="main-content" id="mainContent">

<?php include("../dashboard/includes/navbar.php"); ?>

<div class="content-wrapper">

<div class="container-fluid">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">

Add User

</h2>

<?php echo $message; ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>
    User ID
</label>

<input type="text"
       name="user_id"
       class="form-control"
       value="<?php echo generateUserID($conn); ?>"
       readonly>

</div>

<div class="col-md-6 mb-3">

<label>
    Email
</label>

<input type="email"
       name="email"
       class="form-control"
       required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>
    First Name
</label>

<input type="text"
       name="firstname"
       class="form-control"
       required>

</div>

<div class="col-md-6 mb-3">

<label>
    Last Name
</label>

<input type="text"
       name="lastname"
       class="form-control"
       required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>
    Username
</label>

<input type="text"
       name="username"
       class="form-control"
       required>

</div>

<div class="col-md-6 mb-3">

<label>
    Password
</label>

<input type="password"
       name="password"
       class="form-control"
       required>

</div>

</div>

<div class="mb-4">

<label>
    Role
</label>

<select name="role"
        class="form-control">

<option value="Admin">

Admin

</option>

<option value="Librarian">

Librarian

</option>

</select>

</div>

<button type="submit"
        name="submit"
        class="btn btn-primary">

Add User

</button>

<a href="users.php"
   class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</div>

</body>
</html>