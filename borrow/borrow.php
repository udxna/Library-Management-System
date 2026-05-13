<?php
include("../config/db.php");


if (isset($_POST['submit'])) {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $status = $_POST['status'];
    $date = date("Y-m-d H:i:s");

   
    $borrow_pattern = "/^BR[0-9]{3}$/";
    $book_pattern = "/^B[0-9]{3}$/";
    $member_pattern = "/^M[0-9]{3}$/";

    if (!preg_match($borrow_pattern, $borrow_id)) {
        echo "<script>alert('Invalid Borrow ID! Format: BR001');</script>";
    } elseif (!preg_match($book_pattern, $book_id)) {
        echo "<script>alert('Invalid Book ID! Format: B001');</script>";
    } elseif (!preg_match($member_pattern, $member_id)) {
        echo "<script>alert('Invalid Member ID! Format: M001');</script>";
    } else {
        $query = "INSERT INTO bookborrower (borrow_id, book_id, member_id, borrow_status, borrower_date_modified) 
                  VALUES ('$borrow_id', '$book_id', '$member_id', '$status', '$date')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Record added successfully!'); window.location='borrow.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM bookborrower WHERE borrow_id='$id'");
    header('location: borrow.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class=container mt-5>
    <h2>Borrow Book Details</h2>
     <form method="POST" class="card p-4 mb-5">
        <div class="mb-3">
            <label>Borrow ID (Format: BR001)</label>
            <input type="text" name="borrow_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Book ID (Format: B001)</label>
            <input type="text" name="book_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Member ID (Format: M001)</label>
            <input type="text" name="member_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Borrow Status</label>
            <select name="status" class="form-control">
                <option value="borrowed">Borrowed</option>
                <option value="available">Available</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Record</button>
    </form> 
    <h3>Borrowed Books List</h3>
     <table class="table table-bordered">
        <thead>
            <tr>
                <th>Borrow ID</th>
                <th>Book ID</th>
                <th>Member ID</th>
                <th>Status</th>
                <th>Modified Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM bookborrower");
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['borrow_id']; ?></td>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['member_id']; ?></td>
                    <td><?php echo $row['borrow_status']; ?></td>
                    <td><?php echo $row['borrower_date_modified']; ?></td>
                    <td>
                        <a href="edit_borrow.php?id=<?php echo $row['borrow_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="borrow.php?delete=<?php echo $row['borrow_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
