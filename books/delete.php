<?php

include('../includes/db.php');

$id = $_GET['id'];

$sql = "DELETE FROM book WHERE book_id='$id'";

mysqli_query($conn,$sql);

header("Location:view.php");

?>