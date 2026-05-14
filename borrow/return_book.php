<?php

include("../config/db.php");

$id = $_GET['id'];

/* GET BORROW RECORD */

$stmt = $conn->prepare("
SELECT *
FROM bookborrower
WHERE borrow_id = ?
");

$stmt->bind_param("s", $id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

/* TODAY */

$today = date("Y-m-d");

/* CALCULATE LATE DAYS */

$late_days = floor(
(
strtotime($today) -
strtotime($row['due_date'])
) / 86400
);

/* UPDATE RETURN */

$update = $conn->prepare("
UPDATE bookborrower
SET
borrow_status='Returned',
return_date=?
WHERE borrow_id=?
");

$update->bind_param(
"ss",
$today,
$id
);

$update->execute();

/* CREATE FINE */

if($late_days > 0){

$fine_amount = $late_days * 10;

$fine_id = "F" . rand(100,999);

$fine_stmt = $conn->prepare("
INSERT INTO fine
(
fine_id,
book_id,
member_id,
overdue_days,
fine_amount,
status
)
VALUES (?, ?, ?, ?, ?, 'Unpaid')
");

$fine_stmt->bind_param(
"sssii",
$fine_id,
$row['book_id'],
$row['member_id'],
$late_days,
$fine_amount
);

$fine_stmt->execute();

}

/* REDIRECT */

header("Location: borrow.php");

?>