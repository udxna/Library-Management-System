<?php

include('../includes/db.php');

$id = $_GET['id'];

// 1. delete fine records first
mysqli_query($conn, "DELETE FROM fine WHERE book_id='$id'");

// 2. delete borrower records
mysqli_query($conn, "DELETE FROM bookborrower WHERE book_id='$id'");

// 3. delete book
$sql = "DELETE FROM book WHERE book_id='$id'";

if(mysqli_query($conn,$sql)){
    header("Location:view.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

?>