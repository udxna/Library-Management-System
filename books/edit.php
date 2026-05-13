<?php

include('../includes/db.php');

$id = $_GET['id'];

$sql = "SELECT * FROM book WHERE book_id='$id'";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $bookname = $_POST['bookname'];
    $category = $_POST['category'];

    $update = "UPDATE book
    SET book_name='$bookname',
    category_id='$category'
    WHERE book_id='$id'";

    mysqli_query($conn,$update);

    header("Location:view.php");
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Book</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#d4f5d1;
}

.card{
    margin-top:50px;
    padding:30px;
    border-radius:15px;
    box-shadow:0px 0px 10px gray;
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card">

<h2 class="text-center mb-4">Edit Book</h2>

<form method="POST">

<label>Book Name</label>

<input type="text"
name="bookname"
value="<?php echo $row['book_name']; ?>"
class="form-control">

<label class="mt-3">Category</label>

<input type="text"
name="category"
value="<?php echo $row['category_id']; ?>"
class="form-control">

<br>

<button type="submit"
name="update"
class="btn btn-success w-100">

Update Book

</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>