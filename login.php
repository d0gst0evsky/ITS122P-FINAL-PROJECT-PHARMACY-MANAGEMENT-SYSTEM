<?php
// login.php - login page ng pharmacy system

session_start();

include 'config.php';

// kung naka-login na, i-redirect na sa dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung sinulat sa form
    $uname = $_POST['username'];
    $pword = $_POST['password'];

    // check kung may blanko
    if (empty($uname) || empty($pword)) {
        $error_msg = "Please fill in all fields.";
    } else {
        // hanapin sa database
        $sql = "SELECT * FROM users WHERE username='$uname' AND password='$pword'";
        $result = mysqli_query($conn, $sql);
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data) {
            // tama ang credentials, i-save sa session
            $_SESSION['user_id'] = $user_data['user_id'];
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];

            // i-redirect sa dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            // mali ang username o password
            $error_msg = "Incorrect username or password. Please try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pharmacy System</title>
</head>
<body>

    <h2>Pharmacy Management System</h2>
    <h3>Login</h3>

    <!-- ipakita ang error kung meron -->
    <?php if (!empty($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" placeholder="enter your username"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" placeholder="enter your password"><br><br>

        <button type="submit">Login</button>
        <br><br>

    </form>
</body>
</html>