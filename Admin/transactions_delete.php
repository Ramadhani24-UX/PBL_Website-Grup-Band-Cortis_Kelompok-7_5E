<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "DELETE FROM transactions WHERE transaction_id='$id'";
if(mysqli_query($conn, $query)) {
    echo "<script>alert('Data successfully deleted!'); window.location='transactions_read.php';</script>";
} else {
    echo "<script>alert('Failed to delete data! Check for Foreign Key constraints.'); window.location='transactions_read.php';</script>";
}
?>