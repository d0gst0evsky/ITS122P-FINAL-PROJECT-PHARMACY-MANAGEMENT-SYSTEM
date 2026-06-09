<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $unit = $_POST['unit'];
    $expiry = $_POST['expiry'];

    $query = "INSERT INTO medicines (name, category, price, stock_quantity, unit, expiry_date) 
              VALUES ('$name', '$category', '$price', '$stock', '$unit', '$expiry')";
    
    if (mysqli_query($conn, $query)) {
        header('Location: inventory.php');
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
</head>
<body>
    <h2>Add Medicine</h2>
    <a href="inventory.php">Back to Inventory</a>
    <hr>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name"><br><br>

        <label>Category:</label><br>
        <input type="text" name="category"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price"><br><br>

        <label>Stock Quantity:</label><br>
        <input type="number" name="stock"><br><br>

        <label>Unit:</label><br>
        <input type="text" name="unit"><br><br>

        <label>Expiry Date:</label><br>
        <input type="date" name="expiry"><br><br>

        <button type="submit">Save Medicine</button>
    </form>
</body>
</html>