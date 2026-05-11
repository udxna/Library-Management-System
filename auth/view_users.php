<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

include '../config/db.php';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn,$sql);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="container mt-5">

<div class="card shadow p-4">

<h2 class="mb-4">User List</h2>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>ID</th>
<th>User ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Username</th>
<th>Email</th>
<th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['firstname']; ?></td>
<td><?php echo $row['lastname']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<a href="update_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
Delete
</a>
</td>
</tr>

<?php } ?>

</table>

</div>
</div>

<?php include '../includes/footer.php'; ?>