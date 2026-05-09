<?php
include("../config/db.php");

$message = "";

if(isset($_POST['submit'])){

    $member_id = $_POST['member_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];

    // Id validation
    if(!preg_match("/^M[0-9]{3}$/", $member_id)){

        $message = "Invalid Member ID Format! Example: M001";

    }

    // Email validation
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $message = "Invalid Email Format!";

    }

    else{

        $sql = "INSERT INTO member 
        (member_id, firstname, lastname, birthday, email)
        VALUES
        ('$member_id', '$firstname', '$lastname', '$birthday', '$email')";

        if($conn->query($sql)){

            $message = "Member Added Successfully!";

        } else {

            $message = "Database Error: " . $conn->error;

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow p-4 rounded-4">

                <div class="text-center mb-4">

                    <img src="../assets/images/logo.png" width="100">

                    <h2 class="mt-3">
                        Add Library Member
                    </h2>

                </div>

                    <?php if($message != ""){ ?>

                    <   div class="alert alert-success alert-dismissible fade show"role="alert">

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
                               name="member_id"
                               class="form-control"
                               placeholder="M001"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            First Name
                        </label>

                        <input type="text"
                               name="firstname"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input type="text"
                               name="lastname"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Birthday
                        </label>

                        <input type="date"
                               name="birthday"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="example@email.com"
                               required>

                    </div>

                    <button type="submit"
                            name="submit"
                            class="btn btn-primary w-100">

                        Add Member

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>