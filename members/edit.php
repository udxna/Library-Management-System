<?php
include("../config/db.php");
include("../dashboard/includes/global.php");
include("../dashboard/includes/sidebar.php");
$message = "";

$id = $_GET['id'];

$sql = "SELECT * FROM member WHERE member_id='$id'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $message = "Invalid Email Format!";

    } else {

        $update = "UPDATE member SET

        first_name='$firstname',
        last_name='$lastname',
        birthday='$birthday',
        email='$email'

        WHERE member_id='$id'";

        if($conn->query($update)){

            $message = "Member Updated Successfully!";

            // Refresh data
            $sql = "SELECT * FROM member WHERE member_id='$id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

        } else {

            $message = "Update Failed!";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Member</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<div class="main-content" id="mainContent">
<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow p-4 rounded-4">

<h2 class="text-center mb-4">
Edit Member
</h2>

<?php if($message != ""){ ?>

<div class="alert alert-success alert-dismissible fade show" role="alert">

<?php echo $message; ?>

<button type="button"
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Member ID
</label>

<input type="text"
class="form-control"
value="<?php echo $row['member_id']; ?>"
disabled>

</div>

<div class="mb-3">

<label class="form-label">
First Name
</label>

<input type="text"
name="firstname"
class="form-control"
value="<?php echo $row['first_name']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Last Name
</label>

<input type="text"
name="lastname"
class="form-control"
value="<?php echo $row['last_name']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Birthday
</label>

<input type="date"
name="birthday"
class="form-control"
value="<?php echo $row['birthday']; ?>"
required>

</div>

<div class="mb-4">

<label class="form-label">
Email
</label>

<input type="email"
name="email"
class="form-control"
value="<?php echo $row['email']; ?>"
required>

</div>

<button type="submit"
name="update"
class="btn btn-warning w-100">

Update Member

</button>

</form>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>