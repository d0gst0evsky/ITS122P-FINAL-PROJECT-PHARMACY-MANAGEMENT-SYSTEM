<?php
// edit_medicine.php - para sa pag-edit ng medicine info

session_start();

// i-redirect sa login kung hindi naka-login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// kunin yung id ng medicine na ie-edit
$med_id = $_GET['id'];

// i-fetch yung existing data ng medicine
$fetch = mysqli_query($conn, "SELECT * FROM medicines WHERE medicine_id='$med_id'");
$med_data = mysqli_fetch_assoc($fetch);

// kung wala yung medicine, balik sa inventory
if (!$med_data) {
    header('Location: inventory.php');
    exit();
}

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // kunin yung bagong values galing sa form
    $med_name = $_POST['name'];
    $med_category = $_POST['category'];
    $med_price = $_POST['price'];
    $med_stock = $_POST['stock'];
    $med_unit = $_POST['unit'];
    $med_expiry = $_POST['expiry'];

    // check kung may blanko
    if (empty($med_name) || empty($med_category) || empty($med_price) || empty($med_unit)) {
        $error_msg = "Lahat ng fields ay kailangan punan!";
    } else {
        // i-update sa database
        $sql = "UPDATE medicines SET 
                name='$med_name', 
                category='$med_category', 
                price='$med_price', 
                stock_quantity='$med_stock', 
                unit='$med_unit', 
                expiry_date='$med_expiry' 
                WHERE medicine_id='$med_id'";

        if (mysqli_query($conn, $sql)) {
            // matagumpay na na-update, balik sa inventory
            header('Location: inventory.php');
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
    <title>Edit Medicine - Pharmacy System</title>
</head>
<body>

    <h2>Edit Medicine Info</h2>
    <a href="inventory.php">Back to Inventory</a>
    <hr>

    <!-- ipakita ang error kung meron -->
    <?php if (!empty($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="POST">

        <label>Medicine Name:</label><br>
        <input type="text" name="name" value="<?php echo $med_data['name']; ?>"><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="<?php echo $med_data['category']; ?>"><br><br>

        <label>Price (₱):</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo $med_data['price']; ?>"><br><br>

        <label>Stock Quantity:</label><br>
        <input type="number" name="stock" value="<?php echo $med_data['stock_quantity']; ?>"><br><br>

        <label>Unit:</label><br>
        <input type="text" name="unit" value="<?php echo $med_data['unit']; ?>"><br><br>

        <label>Expiry Date:</label><br>
        <input type="date" name="expiry" value="<?php echo $med_data['expiry_date']; ?>"><br><br>

        <button type="submit">Update Medicine</button>
        <a href="inventory.php">Cancel</a>

    </form>

</body>
</html>