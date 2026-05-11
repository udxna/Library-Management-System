<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
</head>

<body>

<h1>Welcome <?php echo $_SESSION['username']; ?></h1>

<a href="logout.php">Logout</a>
<?php
include 'config/db.php';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn,$sql);
?>

<table class="table table-bordered">

<tr>
<th>User ID</th>
<th>Firstname</th>
<th>Lastname</th>
<th>Username</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['userid']; ?></td>
<td><?php echo $row['firstname']; ?></td>
<td><?php echo $row['lastname']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>