<?php
include 'db_config.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookborrower WHERE borrow_id='$id'"));


?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
   
</head>
<body class="container mt-5">
    
   
</body>
</html>