<?php

include("../config/db.php");
include("../dashboard/includes/sidebar.php");

$message = "";

/* AUTO GENERATE FINE ID */

function generateFineID($conn){

    $query = "
    SELECT fine_id
    FROM fine
    ORDER BY fine_id DESC
    LIMIT 1
    ";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $lastID = $row['fine_id'];

        $number = (int)substr($lastID, 1);

        $newNumber = $number + 1;

        return "F" . str_pad(
            $newNumber,
            3,
            "0",
            STR_PAD_LEFT
        );

    } else {

        return "F001";

    }

}

/* ADD FINE */

if(isset($_POST['submit'])){

    $fine_id = $_POST['fine_id'];

    $book_id = $_POST['book_id'];

    $member_id = $_POST['member_id'];

    $overdue_days = $_POST['overdue_days'];

    $fine_amount = $overdue_days * 10;

    $status = $_POST['status'];

    $date = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("
    INSERT INTO fine
    (
        fine_id,
        book_id,
        member_id,
        overdue_days,
        fine_amount,
        status,
        fine_date_modified
    )
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssisss",
        $fine_id,
        $book_id,
        $member_id,
        $overdue_days,
        $fine_amount,
        $status,
        $date
    );

    if($stmt->execute()){

        echo "

        <script>

        alert('Fine added successfully!');

        window.location='view.php';

        </script>

        ";

        exit();

    } else {

        $message = "Failed to add fine.";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Add Fine</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container mt-5">

<div class="card shadow p-4 rounded-4 border-0">

<h2 class="mb-4">
    Add Fine
</h2>

<?php if($message != ""){ ?>

<div class="alert alert-danger">

    <?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>
    Fine ID
</label>

<input type="text"
       name="fine_id"
       class="form-control"
       value="<?php echo generateFineID($conn); ?>"
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

<option value="<?php echo $b['book_id']; ?>">

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

<option value="<?php echo $m['member_id']; ?>">

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
    Overdue Days
</label>

<input type="number"
       name="overdue_days"
       class="form-control"
       min="1"
       required>

<small class="text-muted">
    Rs. 10 per day
</small>

</div>

<div class="mb-3">

<label>
    Status
</label>

<select name="status"
        class="form-control">

<option value="Unpaid">
    Unpaid
</option>

<option value="Paid">
    Paid
</option>

</select>

</div>

<button type="submit"
        name="submit"
        class="btn btn-primary">

    Add Fine

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