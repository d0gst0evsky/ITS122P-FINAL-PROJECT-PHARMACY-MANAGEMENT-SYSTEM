<?php
// Add Medicine Page - Pharmacy Management System

session_start();

// redirect to login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // kunin yung data galing sa form
    $med_name = $_POST['name'];
    $med_category = $_POST['category'];
    $med_price = $_POST['price'];
    $med_stock = $_POST['stock'];
    $med_unit = $_POST['unit'];
    $med_expiry = $_POST['expiry'];

    // i-insert sa medicines table
    $sql = "INSERT INTO medicines (name, category, price, stock_quantity, unit, expiry_date) 
            VALUES ('$med_name', '$med_category', '$med_price', '$med_stock', '$med_unit', '$med_expiry')";
    
    if (mysqli_query($conn, $sql)) {
        // balik sa inventory kung successful
        header('Location: inventory.php');
    } else {
        $error_msg = "May error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Medicine</title>
</head>
<body>

    <h2>Add New Medicine</h2>
    <a href="inventory.php">Back to Inventory</a>
    <hr>

    <!-- ipakita ang error kung meron -->
    <?php if (isset($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="POST">

        <label>Medicine Name:</label><br>
        <input type="text" name="name" placeholder="ex. Biogesic"><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" placeholder="ex. Painkiller"><br><br>

        <label>Price (₱):</label><br>
        <input type="number" step="0.01" name="price" placeholder="0.00"><br><br>

        <label>Stock Quantity:</label><br>
        <input type="number" name="stock" placeholder="0"><br><br>

        <label>Unit:</label><br>
        <input type="text" name="unit" placeholder="ex. tablet, capsule, bottle"><br><br>

        <label>Expiry Date:</label><br>
        <input type="date" name="expiry"><br><br>

        <button type="submit">Save Medicine</button>
        <a href="inventory.php">Cancel</a>

    </form>

</body>
</html>