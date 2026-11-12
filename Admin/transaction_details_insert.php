<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);
    $variation_id = mysqli_real_escape_string($conn, $_POST['variation_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $subtotal_price = mysqli_real_escape_string($conn, $_POST['subtotal_price']);

    $query = "INSERT INTO transaction_details (transaction_id, variation_id, quantity, subtotal_price) VALUES ('$transaction_id', '$variation_id', '$quantity', '$subtotal_price')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='transaction_details_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Transaction Details</h3>
<div class="card p-4">
    <form action="transaction_details_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">transaction_id</label>
            <input type="number" name="transaction_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">variation_id</label>
            <input type="number" name="variation_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">subtotal_price</label>
            <input type="number" name="subtotal_price" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="transaction_details_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>