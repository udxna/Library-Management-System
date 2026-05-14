<?php

include("../config/db.php");

/* CHECK ID */

if(isset($_GET['id'])){

    $id = $_GET['id'];

    /* DELETE QUERY */

    $stmt = $conn->prepare("
    DELETE FROM fine
    WHERE fine_id=?
    ");

    $stmt->bind_param("s", $id);

    if($stmt->execute()){

        echo "
        <script>

        alert('Fine deleted successfully!');

        window.location='view.php';

        </script>
        ";

    } else {

        echo "
        <script>

        alert('Failed to delete fine.');

        window.location='view.php';

        </script>
        ";

    }

} else {

    header("Location: view.php");

}

?>