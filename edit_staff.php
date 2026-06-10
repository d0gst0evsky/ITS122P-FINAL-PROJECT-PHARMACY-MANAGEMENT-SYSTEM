<?php
// edit_staff.php - para sa pag-edit ng staff member info

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// kunin yung id ng staff na ie-edit
$staff_id = $_GET['id'];

// i-fetch yung existing data ng staff
$fetch = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$staff_id'");
$staff_data = mysqli_fetch_assoc($fetch);

// kung wala yung staff, balik sa staff list
if (!$staff_data) {
    header('Location: staff.php');
    exit();
}

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung bagong values galing sa form
    $uname = $_POST['username'];
    $pword = $_POST['password'];
    $fname = $_POST['full_name'];
    $urole = $_POST['role'];
    $umail = $_POST['email'];

    // check kung may blanko
    if (empty($uname) || empty($pword) || empty($fname) || empty($umail)) {
        $error_msg = "Lahat ng fields ay kailangan punan!";
    } else {
        // i-update sa database
        $sql = "UPDATE users SET 
                username='$uname', 
                password='$pword', 
                full_name='$fname', 
                role='$urole', 
                email='$umail' 
                WHERE user_id='$staff_id'";

        if (mysqli_query($conn, $sql)) {
            // matagumpay na na-update, balik sa staff list
            header('Location: staff.php');
            exit();
        } else {
            $error_msg = "Hindi na-update: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff - Pharmacy System</title>
</head>
<body>

    <h2>Edit Staff Info</h2>
    <a href="staff.php">Back to Staff List</a>
    <hr>

    <!-- ipakita ang error kung meron -->
    <?php if (!empty($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="POST">

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $staff_data['username']; ?>"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" value="<?php echo $staff_data['password']; ?>"><br><br>

        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?php echo $staff_data['full_name']; ?>"><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="admin" <?php if($staff_data['role']=='admin') echo 'selected'; ?>>Admin</option>
            <option value="pharmacist" <?php if($staff_data['role']=='pharmacist') echo 'selected'; ?>>Pharmacist</option>
            <option value="cashier" <?php if($staff_data['role']=='cashier') echo 'selected'; ?>>Cashier</option>
        </select><br><br>

        <label>Email Address:</label><br>
        <input type="email" name="email" value="<?php echo $staff_data['email']; ?>"><br><br>

        <button type="submit">Update Staff</button>
        <a href="staff.php">Cancel</a>

    </form>

</body>
</html>