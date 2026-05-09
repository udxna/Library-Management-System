<?php
include("../config/db.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM member WHERE member_id='$id'";

    if($conn->query($sql)){

        header("Location: view.php");

    } else {

        echo "Delete Failed!";

    }

} else {

    echo "Invalid Request";

}
?>