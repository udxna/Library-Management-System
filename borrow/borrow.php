<?php
include("../config/db.php");


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
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
