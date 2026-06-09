<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $email = $_POST['email'];

    $query = "INSERT INTO users (username, password, full_name, role, email) 
              VALUES ('$username', '$password', '$full_name', '$role', '$email')";

    if (mysqli_query($conn, $query)) {
        header('Location: staff.php');
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
</head>
<body>
    <h2>Add Staff</h2>
    <a href="staff.php">Back to Staff</a>
    <hr>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <label>Full Name:</label><br>
        <input type="text" name="full_name"><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="cashier">Cashier</option>
        </select><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <button type="submit">Save Staff</button>
    </form>
</body>
</html>