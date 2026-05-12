<?php
// register.php
session_start();

// Database connection
$host = "localhost";
$dbname = "library_system";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid    = trim($_POST['userid'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $uname     = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $pass      = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($userid) || empty($firstname) || empty($lastname) || empty($uname) || empty($email) || empty($pass)) {
        $error = "All fields are required.";
    } else {
        // ✅ FIXED: Hash the password properly with PASSWORD_BCRYPT
        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (userid, firstname, lastname, username, password, email, created_at) 
                                   VALUES (:userid, :firstname, :lastname, :username, :password, :email, NOW())");
            $stmt->execute([
                ':userid'    => $userid,
                ':firstname' => $firstname,
                ':lastname'  => $lastname,
                ':username'  => $uname,
                ':password'  => $hashedPassword,   // ✅ Hashed password saved to DB
                ':email'     => $email,
            ]);
            $success = "Registration successful! <a href='login.php'>Login here</a>";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $error = "Username or email already exists.";
            } else {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Library System</title>
</head>
<body>
    <h2>Register</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label>User ID: <input type="text" name="userid" required></label><br><br>
        <label>First Name: <input type="text" name="firstname" required></label><br><br>
        <label>Last Name: <input type="text" name="lastname" required></label><br><br>
        <label>Username: <input type="text" name="username" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Password: <input type="password" name="password" required></label><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>