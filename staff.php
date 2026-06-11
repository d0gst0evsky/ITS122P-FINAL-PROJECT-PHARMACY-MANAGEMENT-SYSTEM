<?php
// staff.php - para makita lahat ng staff members

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// admin lang ang pwedeng makakita ng staff list
if ($_SESSION['role'] != 'admin') {
    header('Location: dashboard.php');
    exit();
}

// kunin lahat ng staff mula sa database
$staff_list = mysqli_query($conn, "SELECT * FROM users ORDER BY full_name ASC");

// i-count kung ilan lahat ng staff
$total_staff = mysqli_num_rows($staff_list);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Pharmacy System</title>
</head>
<body>

    <h2>👥 Staff Management</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <p>Total Staff: <strong><?php echo $total_staff; ?></strong></p>
    <a href="add_staff.php">+ Add New Staff</a>
    <br><br>

    <!-- check kung may staff -->
    <?php if ($total_staff == 0): ?>
        <p>Wala pang staff na naka-rehistro.</p>
    <?php else: ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php while ($staff = mysqli_fetch_assoc($staff_list)): ?>
        <tr>
            <td><?php echo $staff['user_id']; ?></td>
            <td><?php echo $staff['username']; ?></td>
            <td><?php echo $staff['full_name']; ?></td>
            <td>
                <!-- i-highlight ang role -->
                <?php if ($staff['role'] == 'admin'): ?>
                    <span style="color:blue;"><strong><?php echo $staff['role']; ?></strong></span>
                <?php elseif ($staff['role'] == 'pharmacist'): ?>
                    <span style="color:green;"><?php echo $staff['role']; ?></span>
                <?php else: ?>
                    <span style="color:orange;"><?php echo $staff['role']; ?></span>
                <?php endif; ?>
            </td>
            <td><?php echo $staff['email']; ?></td>
            <td>
                <a href="edit_staff.php?id=<?php echo $staff['user_id']; ?>">Edit</a> |
                <!-- hindi pwedeng i-delete ang sarili -->
                <?php if ($staff['user_id'] != $_SESSION['user_id']): ?>
                    <a href="delete_staff.php?id=<?php echo $staff['user_id']; ?>"
                       onclick="return confirm('Sure ka bang i-delete si <?php echo $staff['full_name']; ?>?')">Delete</a>
                <?php else: ?>
                    <span style="color:gray;">This is you.</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

    <?php endif; ?>

</body>
</html>