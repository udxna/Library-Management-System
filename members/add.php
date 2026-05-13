<?php

include("../dashboard/includes/global.php");
include("../config/db.php");

$message = "";
$alertType = "";

if(isset($_POST['submit'])){

    $member_id = trim($_POST['member_id']);
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $birthday  = trim($_POST['birthday']);
    $email     = trim($_POST['email']);

    /* MEMBER ID VALIDATION */

    if(!preg_match("/^M[0-9]{3}$/", $member_id)){

        $message = "Invalid Member ID Format! Example: M001";
        $alertType = "danger";

    }

    /* NAME VALIDATION */

    elseif(
        !preg_match("/^[a-zA-Z ]+$/", $firstname) ||
        !preg_match("/^[a-zA-Z ]+$/", $lastname)
    ){

        $message = "Names should contain only letters.";
        $alertType = "danger";

    }

    /* EMAIL VALIDATION */

    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $message = "Invalid Email Format!";
        $alertType = "danger";

    }

    else{

        /* CHECK DUPLICATE MEMBER ID */

        $check = $conn->prepare("
            SELECT member_id
            FROM member
            WHERE member_id = ?
        ");

        $check->bind_param("s", $member_id);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){

            $message = "Member ID already exists!";
            $alertType = "warning";

        } else {

            /* INSERT MEMBER */

            $stmt = $conn->prepare("
                INSERT INTO member
                (member_id, first_name, last_name, birthday, email)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssss",
                $member_id,
                $firstname,
                $lastname,
                $birthday,
                $email
            );

            if($stmt->execute()){

                $message = "Member Added Successfully!";
                $alertType = "success";

            } else {

                $message = "Database Error: " . $stmt->error;
                $alertType = "danger";

            }

            $stmt->close();

        }

        $check->close();

    }

}

include("../dashboard/includes/sidebar.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="main-content" id="mainContent">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow p-4 rounded-4 border-0">

                <div class="text-center mb-4">

                    <img src="../assets/images/logo.png"
                         width="100">

                    <h2 class="mt-3">
                        Add Library Member
                    </h2>

                </div>

                <!-- ALERT MESSAGE -->

                <?php if($message != ""){ ?>

                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show"
                         role="alert">

                        <?php echo $message; ?>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php } ?>

                <!-- FORM -->

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

                        <small class="text-muted">
                            Format: M001
                        </small>

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

                        <i class="bi bi-person-plus-fill"></i>

                        Add Member

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>