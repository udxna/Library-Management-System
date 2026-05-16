<?php

include("../config/db.php");
include("../dashboard/includes/sidebar.php");
include("../dashboard/includes/navbar.php");

$id = $_GET['id'];

/* MEMBER INFO */

$stmt = $conn->prepare("
SELECT *
FROM member
WHERE member_id=?
");

$stmt->bind_param("s", $id);

$stmt->execute();

$member = $stmt->get_result()->fetch_assoc();

/* BORROW HISTORY */

$borrow = $conn->prepare("
SELECT *
FROM bookborrower
WHERE member_id=?
ORDER BY borrow_date DESC
");

$borrow->bind_param("s", $id);

$borrow->execute();

$borrow_result = $borrow->get_result();

/* FINE HISTORY */

$fine = $conn->prepare("
SELECT *
FROM fine
WHERE member_id=?
ORDER BY fine_date_modified DESC
");

$fine->bind_param("s", $id);

$fine->execute();

$fine_result = $fine->get_result();

/* TOTAL FINES */

$total = $conn->prepare("
SELECT SUM(fine_amount) AS total_fine
FROM fine
WHERE member_id=?
");

$total->bind_param("s", $id);

$total->execute();

$total_result = $total->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Member Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container-fluid mt-4">

<!-- MEMBER DETAILS -->

<div class="card shadow p-4 rounded-4 border-0 mb-4">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="mb-3">

<i class="bi bi-person-circle"></i>

Member Profile

</h2>

<p>

<strong>Member ID:</strong>

<?php echo $member['member_id']; ?>

</p>

<p>

<strong>Full Name:</strong>

<?php

echo
$member['first_name']
. " " .
$member['last_name'];

?>

</p>

<p>

<strong>Email:</strong>

<?php echo $member['email']; ?>

</p>

<p>

<strong>Birthday:</strong>

<?php echo $member['birthday']; ?>

</p>

</div>

<div>

<h3>

<span class="badge bg-danger p-3">

Total Fine:
Rs.
<?php echo $total_result['total_fine'] ?? 0; ?>

</span>

</h3>

</div>

</div>

</div>

<!-- BORROW HISTORY -->

<div class="card shadow p-4 rounded-4 border-0 mb-4">

<h3 class="mb-3">

<i class="bi bi-book"></i>

Borrow History

</h3>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Borrow ID</th>
<th>Book ID</th>
<th>Status</th>
<th>Borrow Date</th>
<th>Due Date</th>
<th>Return Date</th>

</tr>

</thead>

<tbody>

<?php

if($borrow_result->num_rows > 0){

while($row = $borrow_result->fetch_assoc()){

?>

<tr>

<td>
    <?php echo $row['borrow_id']; ?>
</td>

<td>
    <?php echo $row['book_id']; ?>
</td>

<td>

<?php

if($row['borrow_status'] == 'Returned'){

?>

<span class="badge bg-success">

Returned

</span>

<?php } else { ?>

<span class="badge bg-warning text-dark">

Borrowed

</span>

<?php } ?>

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

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="6"
    class="text-center">

    No Borrow History Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- FINE HISTORY -->

<div class="card shadow p-4 rounded-4 border-0">

<h3 class="mb-3">

<i class="bi bi-cash-stack"></i>

Fine History

</h3>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Fine ID</th>
<th>Book ID</th>
<th>Overdue Days</th>
<th>Fine Amount</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

if($fine_result->num_rows > 0){

while($row = $fine_result->fetch_assoc()){

?>

<tr>

<td>
    <?php echo $row['fine_id']; ?>
</td>

<td>
    <?php echo $row['book_id']; ?>
</td>

<td>
    <?php echo $row['overdue_days']; ?>
</td>

<td>
    Rs. <?php echo $row['fine_amount']; ?>
</td>

<td>

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

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="5"
    class="text-center">

    No Fine Records Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="mt-4">

<a href="view.php"
   class="btn btn-secondary">

    Back To Members

</a>

</div>

</div>

</div>

</body>
</html>