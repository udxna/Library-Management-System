<?php

include("../config/db.php");
include("../dashboard/includes/sidebar.php");

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM fine
WHERE fine_id=?
");

$stmt->bind_param("s", $id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['update'])){

    $book_id = $_POST['book_id'];

    $member_id = $_POST['member_id'];

    $overdue_days = $_POST['overdue_days'];

    $fine_amount = $overdue_days * 10;

    $status = $_POST['status'];

    $date = date("Y-m-d H:i:s");

    $update = $conn->prepare("
    UPDATE fine
    SET
    book_id=?,
    member_id=?,
    overdue_days=?,
    fine_amount=?,
    status=?,
    fine_date_modified=?
    WHERE fine_id=?
    ");

    $update->bind_param(
        "ssissss",
        $book_id,
        $member_id,
        $overdue_days,
        $fine_amount,
        $status,
        $date,
        $id
    );

    if($update->execute()){

        $message = "Fine updated successfully!";

        // Refresh data
        header("Location: view.php");

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Fine</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container mt-5">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">
    Edit Fine
</h2>

<form method="POST">

<div class="mb-3">

<label>
    Fine ID
</label>

<input type="text"
       class="form-control"
       value="<?php echo $row['fine_id']; ?>"
       readonly>

</div>

<div class="mb-3">

<label>
    Book ID
</label>

<input type="text"
       name="book_id"
       class="form-control"
       value="<?php echo $row['book_id']; ?>"
       required>

</div>

<div class="mb-3">

<label>
    Member ID
</label>

<input type="text"
       name="member_id"
       class="form-control"
       value="<?php echo $row['member_id']; ?>"
       required>

</div>

<div class="mb-3">

<label>
    Overdue Days
</label>

<input type="number"
       name="overdue_days"
       class="form-control"
       value="<?php echo $row['overdue_days']; ?>"
       required>

<small class="text-muted">
    Rs. 10 per day
</small>

</div>

<div class="mb-3">

<label>
    Fine Amount
</label>

<input type="text"
       class="form-control"
       value="Rs. <?php echo $row['fine_amount']; ?>"
       readonly>

</div>

<div class="mb-3">

<label>
    Status
</label>

<select name="status"
        class="form-control">

<option value="Unpaid"

<?php

if($row['status'] == 'Unpaid'){

echo "selected";

}

?>

>

Unpaid

</option>

<option value="Paid"

<?php

if($row['status'] == 'Paid'){

echo "selected";

}

?>

>

Paid

</option>

</select>

</div>

<button type="submit"
        name="update"
        class="btn btn-primary">

    Update Fine

</button>

<a href="view.php"
   class="btn btn-secondary">

    Back

</a>

</form>

</div>

</div>

</div>

</body>
</html>