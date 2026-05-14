<?php

include("../config/db.php");
include("../dashboard/includes/sidebar.php");

$category_id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM book
    WHERE category_id = ?
");

$stmt->bind_param("s", $category_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Category Books</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container mt-4">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">
    Books In This Category
</h2>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Book ID</th>
<th>Book Name</th>
<th>Category ID</th>

</tr>

</thead>

<tbody>

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

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

</tr>

<?php

    }

} else {

?>

<tr>

<td colspan="3"
    class="text-center">

    No Books Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

<a href="book_category.php"
   class="btn btn-secondary">

    Back

</a>

</div>

</div>

</div>

</body>
</html>