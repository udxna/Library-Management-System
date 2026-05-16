<?php

include("../config/db.php");

if (isset($_POST['submit'])) {

    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $status = $_POST['status'];

    $date = date("Y-m-d H:i:s");

    $borrow_date = date("Y-m-d");

    // Due after 7 days
    $due_date = date(
        "Y-m-d",
        strtotime("+7 days")
    );

    if (!preg_match("/^BR[0-9]{3}$/", $borrow_id)) {

        echo "<script>alert('Invalid Borrow ID!');</script>";

    } else {

        $stmt = $conn->prepare("
        INSERT INTO bookborrower
        (
            borrow_id,
            book_id,
            member_id,
            borrow_status,
            borrower_date_modified,
            borrow_date,
            due_date
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssss",
            $borrow_id,
            $book_id,
            $member_id,
            $status,
            $date,
            $borrow_date,
            $due_date
        );

        try {

            if ($stmt->execute()) {

                echo "
                <script>

                alert('Record added successfully!');

                window.location='borrow.php';

                </script>
                ";

            }

        } catch (mysqli_sql_exception $e) {

            echo "
            <script>

            alert('Error: The Book or Member ID entered does not exist in the system.');

            </script>
            ";

        }

    }

}

/* DELETE */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM bookborrower WHERE borrow_id='$id'"
    );

    header('location: borrow.php');

}

/* AUTO GENERATE BORROW ID */

function generateBorrowID($conn) {

    $query = "
    SELECT borrow_id
    FROM bookborrower
    ORDER BY borrow_id DESC
    LIMIT 1
    ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $lastID = $row['borrow_id'];

        $number = (int)substr($lastID, 2);

        $newNumber = $number + 1;

        return "BR" . str_pad(
            $newNumber,
            3,
            "0",
            STR_PAD_LEFT
        );

    } else {

        return "BR001";

    }

}

?>

<?php include("../dashboard/includes/sidebar.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Borrow Book</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>

<div class="main-content" id="mainContent">
<?php include("../dashboard/includes/navbar.php"); ?>

<div class="container mt-5">

<h2>
    Borrow Book Details
</h2>

<form method="POST"
      class="card p-4 mb-5">

<div class="mb-3">

<label>
    Borrow ID
</label>

<input type="text"
       name="borrow_id"
       class="form-control"
       value="<?php echo $next_borrow_id = generateBorrowID($conn); ?>"
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
    "SELECT book_id, book_name FROM book"
);

while ($b = mysqli_fetch_assoc($books)) {

echo "
<option value='{$b['book_id']}'>

{$b['book_id']} - {$b['book_name']}

</option>
";

}

?>

</select>

</div>

<div class="mb-3">

<label>
    Select Member
</label>

<select name="member_id"
        class="form-control"
        required>

<option value="">
    -- Select Member --
</option>

<?php

$members = mysqli_query(
    $conn,
    "SELECT member_id, first_name, last_name FROM member"
);

while ($m = mysqli_fetch_assoc($members)) {

$fullName =
$m['first_name'] . " " . $m['last_name'];

echo "
<option value='{$m['member_id']}'>

{$m['member_id']} - {$fullName}

</option>
";

}

?>

</select>

</div>

<div class="mb-3">

<label>
    Borrow Status
</label>

<select name="status"
        class="form-control">

<option value="Borrowed">
    Borrowed
</option>

</select>

</div>

<button type="submit"
        name="submit"
        class="btn btn-primary">

    Add Record

</button>

</form>

<h3>
    Borrowed Books List
</h3>

<table class="table table-bordered">

<thead>

<tr>

<th>Borrow ID</th>
<th>Book ID</th>
<th>Member ID</th>
<th>Status</th>
<th>Borrow Date</th>
<th>Due Date</th>
<th>Return Date</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$result = mysqli_query(
    $conn,
    "SELECT * FROM bookborrower"
);

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr>

<td>
    <?php echo $row['borrow_id']; ?>
</td>

<td>
    <?php echo $row['book_id']; ?>
</td>

<td>
    <?php echo $row['member_id']; ?>
</td>

<td>
    <?php echo $row['borrow_status']; ?>
</td>

<td>
    <?php echo $row['borrow_date']; ?>
</td>

<td>
    <?php echo $row['due_date']; ?>
</td>

<td>
    <?php echo $row['return_date']; ?>
</td>

<td>

<a href="return_book.php?id=<?php echo $row['borrow_id']; ?>"
   class="btn btn-success btn-sm">

   Return

</a>

<a href="edit_borrow.php?id=<?php echo $row['borrow_id']; ?>"
   class="btn btn-warning btn-sm">

   Edit

</a>

<a href="borrow.php?delete=<?php echo $row['borrow_id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure?')">

   Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>