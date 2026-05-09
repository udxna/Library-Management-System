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

                    <th class ="text-center">Member ID</th>
                    <th class ="text-center">First Name</th>
                    <th class ="text-center">Last Name</th>
                    <th class ="text-center">Birthday</th>
                    <th class ="text-center">Email</th>
                    <th style="width: 1%;" class ="text-center">Action</th>

                </tr>

            </thead>

            <tbody>

                <?php

                if($result->num_rows > 0){

                    while($row = $result->fetch_assoc()){

                        echo "<tr>

                            <td class ='text-center'>".$row['member_id']."</td>

                            <td class ='text-center'>".$row['first_name']."</td>

                            <td class ='text-center'>".$row['last_name']."</td>

                            <td class ='text-center'>".$row['birthday']."</td>

                            <td class ='text-center'>".$row['email']."</td>
                            <td class='text-nowrap'>

                                <div class='d-flex gap-1'>

                                    <a href='edit.php?id=".$row['member_id']."'
                                    class='btn btn-warning btn-sm px-3'>
                                        Edit
                                    </a>

                                    <a href='delete.php?id=".$row['member_id']."'
                                    class='btn btn-danger btn-sm px-3'
                                    onclick=\"return confirm('Are you sure you want to delete this member?')\">
                                        Delete
                                     </a>

                                </div>

                            </td>
                            

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