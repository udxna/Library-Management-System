<?php

include('../includes/db.php');

/* SEARCH */

$search = $_GET['search'] ?? '';

$sql = "
SELECT
    book.*,

    CASE
        WHEN EXISTS (
            SELECT 1
            FROM bookborrower
            WHERE
                bookborrower.book_id = book.book_id
                AND borrow_status = 'Borrowed'
        )
        THEN 'Borrowed'
        ELSE 'Available'
    END AS availability

FROM book

WHERE
    book.book_id LIKE '%$search%'
    OR book.book_name LIKE '%$search%'
    OR book.category_id LIKE '%$search%'

ORDER BY book.book_id ASC
";

$result = mysqli_query($conn,$sql);

?>

<?php include("../dashboard/includes/sidebar.php"); ?>


<!DOCTYPE html>
<html>

<head>

<title>View Books</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    background:#d4f5d1;
}

.main-content{
    margin-left:250px;
    padding:20px;
}

.container-fluid{
    margin-top:90px;
}

.search-box{
    max-width:350px;
}

</style>

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container-fluid">

<div class="card shadow p-4 rounded-4 border-0">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="mb-0">
    Book List
</h2>

<a href="add.php"
   class="btn btn-primary">

    Add New Book

</a>

</div>

<!-- SEARCH FILTER -->

<form method="GET"
      class="mb-4">

<div class="input-group search-box">

<input type="text"
       name="search"
       class="form-control"
       placeholder="Search books..."
       value="<?php echo htmlspecialchars($search); ?>">

<button class="btn btn-dark"
        type="submit">

    <i class="bi bi-search"></i>

</button>

</div>

</form>

<table class="table table-bordered table-striped bg-white">

<tr class="table-dark">

<th>Book ID</th>
<th>Book Name</th>
<th>Category ID</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

if(mysqli_num_rows($result) > 0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>
    <?php echo $row['book_id']; ?>
</td>

<td>
    <?php echo $row['book_name']; ?>
</td>

<td>
    <?php echo $row['category_id']; ?>
</td>

<td>

<?php

if($row['availability'] == 'Borrowed'){

?>

<span class="badge bg-danger">

Borrowed

</span>

<?php } else { ?>

<span class="badge bg-success">

Available

</span>

<?php } ?>

</td>

<td>

<a href="edit.php?id=<?php echo $row['book_id']; ?>"
   class="btn btn-warning btn-sm">

    Edit

</a>

<a href="delete.php?id=<?php echo $row['book_id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this book?')">

    Delete

</a>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="5"
    class="text-center">

    No Books Found

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>