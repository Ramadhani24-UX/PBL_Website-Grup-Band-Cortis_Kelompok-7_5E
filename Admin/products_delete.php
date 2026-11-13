<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "DELETE FROM products WHERE product_id='$id'";
if(mysqli_query($conn, $query)) {
    echo "<script>alert('Data successfully deleted!'); window.location='products_read.php';</script>";
} else {
    echo "<script>alert('Failed to delete data! Check for Foreign Key constraints.'); window.location='products_read.php';</script>";
}
?>