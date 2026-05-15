<?php

include("../dashboard/includes/global.php");
include("../config/db.php");
include("../dashboard/includes/sidebar.php");

/* AUTO UPDATE FINES */

$today = date("Y-m-d");

/* GET ALL OVERDUE BORROWED BOOKS */

$borrowQuery = "
SELECT *
FROM bookborrower
WHERE
    due_date < '$today'
    AND borrow_status='Borrowed'
";

$borrowResult = mysqli_query($conn, $borrowQuery);

while($borrow = mysqli_fetch_assoc($borrowResult)){

    $borrow_id = $borrow['borrow_id'];

    $book_id = $borrow['book_id'];

    $member_id = $borrow['member_id'];

    /* CALCULATE OVERDUE DAYS */

    $dueDate = new DateTime($borrow['due_date']);

    $currentDate = new DateTime($today);

    $overdue_days = $dueDate->diff($currentDate)->days;

    /* RS 10 PER DAY */

    $fine_amount = $overdue_days * 10;

    /* CHECK EXISTING UNPAID FINE */

    $checkFine = mysqli_query(
        $conn,
        "
        SELECT *
        FROM fine
        WHERE
            borrow_id='$borrow_id'
            AND status='Unpaid'
        "
    );

    /* UPDATE EXISTING */

    if(mysqli_num_rows($checkFine) > 0){

        mysqli_query(
            $conn,
            "
            UPDATE fine
            SET
                overdue_days='$overdue_days',
                fine_amount='$fine_amount',
                fine_date_modified=NOW()
            WHERE
                borrow_id='$borrow_id'
                AND status='Unpaid'
            "
        );

    } else {

        /* GENERATE FINE ID */

        $fineQuery = mysqli_query(
            $conn,
            "
            SELECT fine_id
            FROM fine
            ORDER BY fine_id DESC
            LIMIT 1
            "
        );

        if(mysqli_num_rows($fineQuery) > 0){

            $fineRow = mysqli_fetch_assoc($fineQuery);

            $number = intval(substr($fineRow['fine_id'],1));

            $number++;

        } else {

            $number = 1;

        }

        $fine_id = "F" . str_pad(
            $number,
            3,
            "0",
            STR_PAD_LEFT
        );

        /* INSERT NEW FINE */

        mysqli_query(
            $conn,
            "
            INSERT INTO fine
            (
                fine_id,
                borrow_id,
                book_id,
                member_id,
                overdue_days,
                fine_amount,
                status,
                fine_date_modified
            )
            VALUES
            (
                '$fine_id',
                '$borrow_id',
                '$book_id',
                '$member_id',
                '$overdue_days',
                '$fine_amount',
                'Unpaid',
                NOW()
            )
            "
        );

    }

}

/* FETCH FINES */

$sql = "
SELECT *
FROM fine
ORDER BY fine_date_modified DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>View Fines</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

</head>

<body>

<div class="main-content" id="mainContent">

<?php include("../dashboard/includes/navbar.php"); ?>

<div class="container-fluid">

<div class="card shadow p-4 rounded-4 border-0">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>

Library Fines

</h2>

</div>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th class="text-center">
    Fine ID
</th>

<th class="text-center">
    Borrow ID
</th>

<th class="text-center">
    Book ID
</th>

<th class="text-center">
    Member ID
</th>

<th class="text-center">
    Overdue Days
</th>

<th class="text-center">
    Fine Amount
</th>

<th class="text-center">
    Status
</th>

<th class="text-center">
    Last Updated
</th>

<th class="text-center">
    Action
</th>

</tr>

</thead>

<tbody>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<tr>

<td class="text-center">

<?php echo $row['fine_id']; ?>

</td>

<td class="text-center">

<?php echo $row['borrow_id']; ?>

</td>

<td class="text-center">

<?php echo $row['book_id']; ?>

</td>

<td class="text-center">

<?php echo $row['member_id']; ?>

</td>

<td class="text-center">

<?php echo $row['overdue_days']; ?>

Days

</td>

<td class="text-center">

Rs. <?php echo $row['fine_amount']; ?>

</td>

<td class="text-center">

<?php

if($row['status'] == 'Paid'){

?>

<span class="badge bg-success">

Paid

</span>

<?php } else { ?>

<span class="badge bg-danger">

Unpaid

</span>

<?php } ?>

</td>

<td class="text-center">

<?php echo $row['fine_date_modified']; ?>

</td>

<td class="text-center text-nowrap">

<?php

if($row['status'] == 'Unpaid'){

?>

<a href="pay.php?id=<?php echo $row['fine_id']; ?>"
class="btn btn-success btn-sm">

Mark Paid

</a>

<?php } ?>

<a href="delete.php?id=<?php echo $row['fine_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this fine?')">

Delete

</a>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="9"
class="text-center">

No Fine Records Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>