<?php
// inventory.php - para makita lahat ng medicines

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// i-check ang role ng user
$is_admin = ($_SESSION['role'] == 'admin');

// kunin lahat ng medicines galing sa database
$med_list = mysqli_query($conn, "SELECT * FROM medicines ORDER BY name ASC");

// i-count kung ilan ang medicines
$total_meds = mysqli_num_rows($med_list);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Pharmacy System</title>
</head>
<body>

    <h2>Medicine Inventory</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <p>Total Medicines: <strong><?php echo $total_meds; ?></strong></p>
    <?php if ($is_admin): ?>
        <a href="add_medicine.php">+ Add New Medicine</a>
    <?php endif; ?>    <br><br>

    <!-- check kung may laman ang inventory -->
    <?php if ($total_meds == 0): ?>
        <p>Wala pang medicine sa inventory. Mag-add na!</p>
    <?php else: ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Medicine Name</th>
            <th>Category</th>
            <th>Price (₱)</th>
            <th>Stock</th>
            <th>Unit</th>
            <th>Expiry Date</th>
            <th>Actions</th>
        </tr>

        <?php while ($med = mysqli_fetch_assoc($med_list)): ?>
        <tr>
            <td><?php echo $med['medicine_id']; ?></td>
            <td><?php echo $med['name']; ?></td>
            <td><?php echo $med['category']; ?></td>
            <td>₱<?php echo $med['price']; ?></td>
            <td>
                <!-- i-highlight kung mababa na ang stock -->
                <?php if ($med['stock_quantity'] <= $med['reorder_level']): ?>
                    <span style="color:red;"><?php echo $med['stock_quantity']; ?> ⚠️</span>
                <?php else: ?>
                    <?php echo $med['stock_quantity']; ?>
                <?php endif; ?>
            </td>
            <td><?php echo $med['unit']; ?></td>
            <td><?php echo $med['expiry_date']; ?></td>
            <td>
                <?php if ($is_admin): ?>
                    <a href="edit_medicine.php?id=<?php echo $med['medicine_id']; ?>">Edit</a> |
                    <a href="delete_medicine.php?id=<?php echo $med['medicine_id']; ?>" 
                       onclick="return confirm('Sure ka bang i-delete ito?')">Delete</a>
                <?php else: ?>
                    <span style="color:gray;">View Only</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

    <?php endif; ?>

</body>
</html>