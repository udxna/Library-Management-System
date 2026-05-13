<?php

include('../includes/db.php');

if(isset($_POST['submit'])){

    $bookid = $_POST['bookid'];
    $bookname = $_POST['bookname'];
    $category = $_POST['category'];

    // Validate Book ID
    if(!preg_match("/^B[0-9]{3}$/",$bookid)){

        echo "<div class='alert alert-danger text-center'>
        Invalid Book ID Format
        </div>";

    } else {

        // check category exists in DB
        $check = mysqli_query($conn, "SELECT * FROM bookcategory WHERE category_id='$category'");

        if(mysqli_num_rows($check) == 0){
            echo "<div class='alert alert-danger text-center'>
            Invalid Category ❌
            </div>";
        } else {

            $sql = "INSERT INTO book(book_id,book_name,category_id)
            VALUES('$bookid','$bookname','$category')";

            if(mysqli_query($conn,$sql)){
                echo "<div class='alert alert-success text-center'>
                Book Added Successfully ✅
                </div>";
            } else {
                echo mysqli_error($conn);
            }
        }
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
<input type="text" name="bookid" class="form-control" placeholder="B001" required>

<label class="mt-3">Book Name</label>
<input type="text" name="bookname" class="form-control" required>

<label class="mt-3">Category</label>

<!-- FIXED: now using category_id -->
<select name="category" class="form-control" required>

<?php
$result = mysqli_query($conn,"SELECT * FROM bookcategory");
while($row = mysqli_fetch_assoc($result)){
?>
    <option value="<?php echo $row['category_id']; ?>">
        <?php echo $row['category_name']; ?>
    </option>
<?php } ?>

</select>

<br>

<button type="submit" name="submit" class="btn btn-primary w-100">
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