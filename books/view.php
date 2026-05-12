<?php

include('../includes/db.php');

$sql = "SELECT * FROM book";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>View Books</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#d4f5d1;
}

.container{
    margin-top:50px;
}

</style>

</head>

<body>

<div class="container">

<h2 class="text-center mb-4">Book List</h2>

<table class="table table-bordered table-striped bg-white">

<tr class="table-dark">

<th>Book ID</th>
<th>Book Name</th>
<th>Category</th>
<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['book_id']; ?></td>

<td><?php echo $row['book_name']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['book_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="delete.php?id=<?php echo $row['book_id']; ?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

<a href="add.php" class="btn btn-primary">
Add New Book
</a>

</div>

</body>
</html>