<?php
include("../config/db.php");

$sql = "SELECT * FROM member";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Members</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4 rounded-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Library Members
            </h2>

            <a href="add.php" class="btn btn-primary">
                Add Member
            </a>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birthday</th>
                    <th>Email</th>

                </tr>

            </thead>

            <tbody>

                <?php

                if($result->num_rows > 0){

                    while($row = $result->fetch_assoc()){

                        echo "<tr>

                            <td>".$row['member_id']."</td>

                            <td>".$row['first_name']."</td>

                            <td>".$row['last_name']."</td>

                            <td>".$row['birthday']."</td>

                            <td>".$row['email']."</td>

                        </tr>";

                    }

                } else {

                    echo "<tr>
                            <td colspan='5' class='text-center'>
                                No Members Found
                            </td>
                          </tr>";

                }

                ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>