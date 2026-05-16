<?php

include("../config/db.php");
include("../dashboard/includes/sidebar.php");

/* GET RECORD */

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM bookborrower
WHERE borrow_id = ?
");

$stmt->bind_param("s", $id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

/* UPDATE */

if(isset($_POST['update'])){

    $book_id = $_POST['book_id'];

    $member_id = $_POST['member_id'];

    $status = $_POST['status'];

    $due_date = $_POST['due_date'];

    $update = $conn->prepare("
    UPDATE bookborrower
    SET
    book_id=?,
    member_id=?,
    borrow_status=?,
    due_date=?
    WHERE borrow_id=?
    ");

    $update->bind_param(
        "sssss",
        $book_id,
        $member_id,
        $status,
        $due_date,
        $id
    );

    if($update->execute()){

        echo "
        <script>

        alert('Borrow record updated successfully!');

        window.location='borrow.php';

        </script>
        ";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Borrow</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container mt-5">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">
    Edit Borrow Record
</h2>

<form method="POST">

<div class="mb-3">

<label>
    Borrow ID
</label>

<input type="text"
       class="form-control"
       value="<?php echo $row['borrow_id']; ?>"
       readonly>

</div>

<div class="mb-3">

<label>
    Select Book
</label>

<select name="book_id"
        class="form-control"
        required>

<?php

$books = mysqli_query(
    $conn,
    "SELECT * FROM book"
);

while($b = mysqli_fetch_assoc($books)){

?>

<option value="<?php echo $b['book_id']; ?>"

<?php

if($b['book_id'] == $row['book_id']){

echo "selected";

}

?>

>

<?php echo $b['book_id']; ?>
-
<?php echo $b['book_name']; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>
    Select Member
</label>

<select name="member_id"
        class="form-control"
        required>

<?php

$members = mysqli_query(
    $conn,
    "SELECT * FROM member"
);

while($m = mysqli_fetch_assoc($members)){

?>

<option value="<?php echo $m['member_id']; ?>"

<?php

if($m['member_id'] == $row['member_id']){

echo "selected";

}

?>

>

<?php

echo $m['member_id']
. " - " .
$m['first_name']
. " " .
$m['last_name'];

?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>
    Borrow Status
</label>

<select name="status"
        class="form-control">

<option value="Borrowed"

<?php

if($row['borrow_status'] == 'Borrowed'){

echo "selected";

}

?>

>

Borrowed

</option>

<option value="Returned"

<?php

if($row['borrow_status'] == 'Returned'){

echo "selected";

}

?>

>

Returned

</option>

</select>

</div>

<div class="mb-3">

<label>
    Due Date
</label>

<input type="date"
       name="due_date"
       class="form-control"
       value="<?php echo $row['due_date']; ?>"
       required>

</div>

<button type="submit"
        name="update"
        class="btn btn-primary">

    Update Record

</button>

<a href="borrow.php"
   class="btn btn-secondary">

    Cancel

</a>

</form>

</div>

</div>

</div>

</body>
</html>