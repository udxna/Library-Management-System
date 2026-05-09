<?php

$conn = new mysqli("localhost", "root", "", "library_test");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

?>
