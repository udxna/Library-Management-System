<?php
include 'db_config.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookborrower WHERE borrow_id='$id'"));

if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $date = date("Y-m-d H:i:s");
    

   
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
   
</head>
<body class="container mt-5">
    
   
</body>
</html>