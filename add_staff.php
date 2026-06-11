<?php
// Add Staff Page - Pharmacy Management System

session_start();

// pag hindi naka-login, i-redirect sa login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung inputs galing sa form
    $uname = $_POST['username'];
    $pword = $_POST['password'];
    $fname = $_POST['full_name'];
    $urole = $_POST['role'];
    $umail = $_POST['email'];

    // check kung may blanko
    if (empty($uname) || empty($pword) || empty($fname) || empty($umail)) {
        $error_msg = "All fields are required!";
    } else {
        // i-save sa database
        $sql = "INSERT INTO users (username, password, full_name, role, email) 
                VALUES ('$uname', '$pword', '$fname', '$urole', '$umail')";

        if (mysqli_query($conn, $sql)) {
            // successful, balik sa staff list
            header('Location: staff.php');
            exit();
        } else {
            $error_msg = "Hindi na-save: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff Member</title>
</head>
<body>

    <h2>Add New Staff Member</h2>
    <a href="staff.php">Back to Staff List</a>
    <hr>

    <!-- error message -->
    <?php if (!empty($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" placeholder="ex. jdelacruz"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" placeholder="minimum 6 characters"><br><br>

        <label>Full Name:</label><br>
        <input type="text" name="full_name" placeholder="ex. Juan dela Cruz"><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="" disabled selected>-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="cashier">Cashier</option>
        </select><br><br>

        <label>Email Address:</label><br>
        <input type="email" name="email" placeholder="ex. juan@email.com"><br><br>

        <button type="submit">Save Staff</button>
        <a href="staff.php">Cancel</a>

    </form>

</body>
</html>