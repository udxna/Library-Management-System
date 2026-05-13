<?php

include('../includes/db.php');

if(isset($_POST['submit'])){

    $bookid = $_POST['bookid'];
    $bookname = $_POST['bookname'];
    $category = $_POST['category'];

    // 1. Book ID validation
    if(!preg_match("/^B[0-9]{3}$/",$bookid)){

        echo "<div class='alert alert-danger text-center'>
        Invalid Book ID Format (Example: B001)
        </div>";

    } else {

        // 2. Check duplicate book_id
        $checkBook = mysqli_query($conn, "SELECT * FROM book WHERE book_id='$bookid'");

        if(mysqli_num_rows($checkBook) > 0){

            echo "<div class='alert alert-danger text-center'>
            Book ID already exists ❌
            </div>";

        } else {

            // 3. Check category exists (foreign key safety)
            $checkCat = mysqli_query($conn, "SELECT * FROM bookcategory WHERE category_id='$category'");

            if(mysqli_num_rows($checkCat) == 0){

                echo "<div class='alert alert-danger text-center'>
                Invalid Category ❌
                </div>";

            } else {

                // 4. Insert book
                $sql = "INSERT INTO book(book_id, book_name, category_id)
                        VALUES('$bookid','$bookname','$category')";

                if(mysqli_query($conn,$sql)){

                    echo "<div class='alert alert-success text-center'>
                    Book Added Successfully ✅
                    </div>";

                } else {
                    echo "<div class='alert alert-danger text-center'>
                    Error: ".mysqli_error($conn)."
                    </div>";
                }
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