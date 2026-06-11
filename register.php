<?php
// register.php - registration page para sa bagong user

session_start();
include 'config.php';

// kung hindi naka-login, i-redirect sa login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// admin lang ang pwedeng mag-register ng bagong user
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit();
}

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung inputs galing sa form
    $uname = $_POST['username'];
    $pword = $_POST['password'];
    $pword2 = $_POST['confirm_password'];
    $fname = $_POST['full_name'];
    $umail = $_POST['email'];

    // check kung may blanko
    if (empty($uname) || empty($pword) || empty($fname) || empty($umail)) {
        $error_msg = "All fields are required!";

    // check kung tugma ang password
    } elseif ($pword != $pword2) {
        $error_msg = "Passwords do not match. Please try again!";

    // check kung may existing na username
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$uname'");
        
        if (mysqli_num_rows($check) > 0) {
            $error_msg = "This username is already in use. Please choose another one.";
        } else {
            // i-save sa database bilang regular user
            $sql = "INSERT INTO users (username, password, full_name, role, email) 
                    VALUES ('$uname', '$pword', '$fname', 'cashier', '$umail')";

            if (mysqli_query($conn, $sql)) {
                $success_msg = "Successfully registered! You can now log in.";
            } else {
                $error_msg = "There was an error during registration: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pharmacy System</title>
</head>
<body>

    <h2>Pharmacy Management System</h2>
    <h3>Register</h3>

    <!-- ipakita ang error o success message -->
    <?php if (!empty($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>
    <?php if (!empty($success_msg)) echo "<p style='color:green;'>$success_msg</p>"; ?>

    <form method="POST">

        <label>Full Name:</label><br>
        <input type="text" name="full_name" placeholder="ex. Juan dela Cruz"><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" placeholder="ex. jdelacruz"><br><br>

        <label>Email Address:</label><br>
        <input type="email" name="email" placeholder="ex. juan@email.com"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" placeholder="minimum 6 characters"><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" placeholder="repeat the password"><br><br>

        <button type="submit">Register</button>
        <br><br>

    </form>

</body>
</html>