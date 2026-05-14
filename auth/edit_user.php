<?php

include("../config/db.php");

$message = "";

$id = $_GET['id'] ?? '';

/* FETCH USER */

$stmt = $conn->prepare("
SELECT *
FROM users
WHERE user_id=?
");

$stmt->bind_param("s", $id);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if(!$user){

    die("User not found");

}

/* UPDATE USER */

if(isset($_POST['submit'])){

    $firstname = $_POST['firstname'];

    $lastname = $_POST['lastname'];

    $email = $_POST['email'];

    $username = $_POST['username'];

    $role = $_POST['role'];

    $old_password = $_POST['old_password'];

    /* VERIFY OLD PASSWORD */

    if(!password_verify($old_password, $user['password'])){

        $message = "
        <div class='alert alert-danger'>

        Old password is incorrect!

        </div>
        ";

    } else {

        /* UPDATE WITHOUT NEW PASSWORD */

        if(empty($_POST['password'])){

            $update = $conn->prepare("
            UPDATE users
            SET
                firstname=?,
                lastname=?,
                email=?,
                username=?,
                role=?
            WHERE user_id=?
            ");

            $update->bind_param(
                "ssssss",
                $firstname,
                $lastname,
                $email,
                $username,
                $role,
                $id
            );

        } else {

            /* UPDATE WITH NEW PASSWORD */

            $password = password_hash(
                $_POST['password'],
                PASSWORD_DEFAULT
            );

            $update = $conn->prepare("
            UPDATE users
            SET
                firstname=?,
                lastname=?,
                email=?,
                username=?,
                password=?,
                role=?
            WHERE user_id=?
            ");

            $update->bind_param(
                "sssssss",
                $firstname,
                $lastname,
                $email,
                $username,
                $password,
                $role,
                $id
            );

        }

        if($update->execute()){

            echo "

            <script>

            alert('User updated successfully!');

            window.location='users.php';

            </script>

            ";

            exit();

        } else {

            $message = "
            <div class='alert alert-danger'>

            Failed to update user!

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

<title>Edit User</title>

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



<div class="content-wrapper">

<div class="container-fluid">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">

Edit User

</h2>

<?php echo $message; ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>
    User ID
</label>

<input type="text"
       class="form-control"
       value="<?php echo $user['user_id']; ?>"
       readonly>

</div>

<div class="col-md-6 mb-3">

<label>
    Email
</label>

<input type="email"
       name="email"
       class="form-control"
       value="<?php echo $user['email']; ?>"
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
       value="<?php echo $user['firstname']; ?>"
       required>

</div>

<div class="col-md-6 mb-3">

<label>
    Last Name
</label>

<input type="text"
       name="lastname"
       class="form-control"
       value="<?php echo $user['lastname']; ?>"
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
       value="<?php echo $user['username']; ?>"
       required>

</div>

<div class="col-md-6 mb-3">

<label>
    Old Password
</label>

<input type="password"
       name="old_password"
       class="form-control"
       required>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>
    New Password
</label>

<input type="password"
       name="password"
       class="form-control">

<small class="text-muted">

Leave blank to keep current password

</small>

</div>

<div class="col-md-6 mb-3">

<label>
    Role
</label>

<select name="role"
        class="form-control">

<option value="Admin"
<?php if($user['role'] == 'Admin') echo 'selected'; ?>>

Admin

</option>

<option value="Librarian"
<?php if($user['role'] == 'Librarian') echo 'selected'; ?>>

Librarian

</option>

</select>

</div>

</div>

<button type="submit"
        name="submit"
        class="btn btn-primary">

Update User

</button>

<a href="view_users.php"
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