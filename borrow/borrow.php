<?php
include("../config/db.php");


if (isset($_POST['submit'])) {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $status = $_POST['status'];
    $date = date("Y-m-d H:i:s");

   
    if (!preg_match("/^BR[0-9]{3}$/", $borrow_id)) {
        echo "<script>alert('Invalid Borrow ID!');</script>";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO bookborrower (borrow_id, book_id, member_id, borrow_status, borrower_date_modified) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $borrow_id, $book_id, $member_id, $status, $date);

        try {
            if ($stmt->execute()) {
                echo "<script>alert('Record added successfully!'); window.location='borrow.php';</script>";
            }
        } catch (mysqli_sql_exception $e) {
           
            echo "<script>alert('Error: The Book or Member ID entered does not exist in the system.');</script>";
        }
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM bookborrower WHERE borrow_id='$id'");
    header('location: borrow.php');
}
function generateBorrowID($conn) {
    $query = "SELECT borrow_id FROM bookborrower ORDER BY borrow_id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

   
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
            <label>Select Book</label>
    <select name="book_id" class="form-control" required>
        <?php
        $books = mysqli_query($conn, "SELECT book_id, book_name FROM book");
        while ($b = mysqli_fetch_assoc($books)) {
            echo "<option value='{$b['book_id']}'>{$b['book_id']} - {$b['book_name']}</option>";
        }
        ?>
    </select>
        </div>
       <div class="mb-3">
    <label>Select Member</label>
    <select name="member_id" class="form-control" required>
        <option value="">-- Select Member --</option>
        <?php
        // member_name kiyala column ekak nathi nisa first_name, last_name use karanna
        $members = mysqli_query($conn, "SELECT member_id, first_name, last_name FROM member");
        
        if ($members) {
            while ($m = mysqli_fetch_assoc($members)) {
                // Name eka hadaganne mehemai
                $fullName = $m['first_name'] . " " . $m['last_name'];
                echo "<option value='{$m['member_id']}'>{$m['member_id']} - {$fullName}</option>";
            }
        } else {
            echo "<option>No members found</option>";
        }
        ?>
    </select>
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



