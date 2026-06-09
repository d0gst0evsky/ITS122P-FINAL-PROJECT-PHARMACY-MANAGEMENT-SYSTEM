<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'config.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM medicines WHERE medicine_id='$id'");
$medicine = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $unit = $_POST['unit'];
    $expiry = $_POST['expiry'];

    $query = "UPDATE medicines SET name='$name', category='$category', price='$price', 
              stock_quantity='$stock', unit='$unit', expiry_date='$expiry' 
              WHERE medicine_id='$id'";

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
    <title>Edit Medicine</title>
</head>
<body>
    <h2>Edit Medicine</h2>
    <a href="inventory.php">Back to Inventory</a>
    <hr>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $medicine['name']; ?>"><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="<?php echo $medicine['category']; ?>"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo $medicine['price']; ?>"><br><br>

        <label>Stock Quantity:</label><br>
        <input type="number" name="stock" value="<?php echo $medicine['stock_quantity']; ?>"><br><br>

        <label>Unit:</label><br>
        <input type="text" name="unit" value="<?php echo $medicine['unit']; ?>"><br><br>

        <label>Expiry Date:</label><br>
        <input type="date" name="expiry" value="<?php echo $medicine['expiry_date']; ?>"><br><br>

        <button type="submit">Update Medicine</button>
    </form>
</body>
</html>