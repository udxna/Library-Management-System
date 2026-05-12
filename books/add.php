<?php

include('../includes/db.php');

if(isset($_POST['submit'])){

    $bookid = $_POST['bookid'];
    $bookname = $_POST['bookname'];
    $category = $_POST['category'];

    // Validation
    if(!preg_match("/^B[0-9]{3}$/",$bookid)){

        echo "<div class='alert alert-danger text-center'>
        Invalid Book ID Format
        </div>";

    }else{

        $sql = "INSERT INTO book(book_id,book_name,category)
        VALUES('$bookid','$bookname','$category')";

        mysqli_query($conn,$sql);

        echo "<div class='alert alert-success text-center'>
        Book Added Successfully
        </div>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Book Registration</title>

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

<h2 class="text-center mb-4">Book Registration</h2>

<form method="POST">

<label>Book ID</label>

<input type="text"
name="bookid"
class="form-control"
placeholder="B001"
required>

<label class="mt-3">Book Name</label>

<input type="text"
name="bookname"
class="form-control"
required>

<label class="mt-3">Category</label>

<select name="category" class="form-control">

<option>Novel</option>
<option>Science</option>
<option>Education</option>
<option>History</option>

</select>

<br>

<button type="submit"
name="submit"
class="btn btn-primary w-100">

Add Book

</button>

</form>

<br>

<a href="view.php" class="text-center d-block">
View Books
</a>

</div>

</div>

</div>

</div>

</body>
</html>