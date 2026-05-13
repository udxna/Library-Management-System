<?php
include 'db_config.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookborrower WHERE borrow_id='$id'"));

if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $date = date("Y-m-d H:i:s");
    
    $update_query = "UPDATE bookborrower SET borrow_status='$status', borrower_date_modified='$date' WHERE borrow_id='$id'";
    if (mysqli_query($conn, $update_query)) {
        header('location: borrow.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Borrow Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Update Borrow Status</h2>
    <form method="POST" class="card p-4">
        <p>Borrow ID: <b><?php echo $data['borrow_id']; ?></b></p>
        
       
       
    </form>
</body>
</html>