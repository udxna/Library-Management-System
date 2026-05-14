<?php

include("../config/db.php");

$sql = "
SELECT *
FROM users
ORDER BY user_id ASC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Users Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    overflow-x:hidden;
    background:#f4f6f9;
}

/* MAIN CONTENT */

.main-content{
    margin-left:250px;
    padding:20px;
    transition:0.3s;
}

/* TOP SPACE */

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

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="mb-0">

<i class="bi bi-people-fill"></i>

System Users

</h2>

<a href="add_user.php"
   class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Add User

</a>

</div>

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th class="text-center">
    User ID
</th>

<th class="text-center">
    First Name
</th>

<th class="text-center">
    Last Name
</th>

<th class="text-center">
    Email
</th>

<th class="text-center">
    Username
</th>

<th class="text-center">
    Role
</th>

<th class="text-center">
    Created At
</th>

<th class="text-center">
    Action
</th>

</tr>

</thead>

<tbody>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<tr>

<td class="text-center">

<?php echo $row['user_id']; ?>

</td>

<td class="text-center">

<?php echo $row['firstname']; ?>

</td>

<td class="text-center">

<?php echo $row['lastname']; ?>

</td>

<td class="text-center">

<?php echo $row['email']; ?>

</td>

<td class="text-center">

<?php echo $row['username']; ?>

</td>

<td class="text-center">

<?php

if(isset($row['role'])){

if($row['role'] == 'Admin'){

?>

<span class="badge bg-danger">

Admin

</span>

<?php } else { ?>

<span class="badge bg-primary">

Librarian

</span>

<?php

}

} else {

?>

<span class="badge bg-secondary">

No Role

</span>

<?php } ?>

</td>

<td class="text-center">

<?php echo $row['created_at']; ?>

</td>

<td class="text-center text-nowrap">

<a href="edit_user.php?id=<?php echo $row['user_id']; ?>"
   class="btn btn-warning btn-sm">

<i class="bi bi-pencil-square"></i>

Edit

</a>

<a href="delete_user.php?id=<?php echo $row['user_id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this user?')">

<i class="bi bi-trash"></i>

Delete

</a>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="8"
    class="text-center">

No Users Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>
</html>