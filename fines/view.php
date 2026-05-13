<?php

include("../dashboard/includes/global.php");
include("../config/db.php");
include("../dashboard/includes/sidebar.php");

$sql = "SELECT * FROM fine";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>View Fines</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="main-content" id="mainContent">
<?php include("../dashboard/includes/navbar.php"); ?>

<div class="container-fluid">

    <div class="card shadow p-4 rounded-4 border-0">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Library Fines
            </h2>

            <a href="add.php"
               class="btn btn-primary">

                Add Fine

            </a>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th class="text-center">Fine ID</th>
                    <th class="text-center">Book ID</th>
                    <th class="text-center">Member ID</th>
                    <th class="text-center">Overdue Days</th>
                    <th class="text-center">Fine Amount</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date Modified</th>
                    <th class="text-center">Action</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if($result->num_rows > 0){

                while($row = $result->fetch_assoc()){

                    ?>

                    <tr>

                        <td class="text-center">
                            <?php echo $row['fine_id']; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row['book_id']; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row['member_id']; ?>
                        </td>

                        <td class="text-center">
                            <?php echo $row['overdue_days']; ?>
                        </td>

                        <td class="text-center">
                            Rs. <?php echo $row['fine_amount']; ?>
                        </td>

                        <td class="text-center">

                            <?php if($row['status'] == 'Paid'){ ?>

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-danger">
                                    Unpaid
                                </span>

                            <?php } ?>

                        </td>

                        <td class="text-center">
                            <?php echo $row['fine_date_modified']; ?>
                        </td>

                        <td class="text-center text-nowrap">

                            <a href="edit.php?id=<?php echo $row['fine_id']; ?>"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <a href="delete.php?id=<?php echo $row['fine_id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this fine?')">

                                Delete

                            </a>

                        </td>

                    </tr>

                    <?php

                }

            } else {

                ?>

                <tr>

                    <td colspan="8"
                        class="text-center">

                        No Fine Records Found

                    </td>

                </tr>

                <?php

            }

            ?>

            </tbody>

        </table>

    </div>

</div>

</div>

</body>
</html>