<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$id'");
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $email = $_POST['email'];

    $query = "UPDATE users SET username='$username', password='$password', 
              full_name='$full_name', role='$role', email='$email' 
              WHERE user_id='$id'";

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
    <title>Edit Staff</title>
</head>
<body>
    <h2>Edit Staff</h2>
    <a href="staff.php">Back to Staff</a>
    <hr>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $user['username']; ?>"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" value="<?php echo $user['password']; ?>"><br><br>

        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>"><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
            <option value="pharmacist" <?php if($user['role']=='pharmacist') echo 'selected'; ?>>Pharmacist</option>
            <option value="cashier" <?php if($user['role']=='cashier') echo 'selected'; ?>>Cashier</option>
        </select><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

        <button type="submit">Update Staff</button>
    </form>
</body>
</html>