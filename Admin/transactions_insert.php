<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_phone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
    $courier_service = mysqli_real_escape_string($conn, $_POST['courier_service']);
    $shipping_cost = mysqli_real_escape_string($conn, $_POST['shipping_cost']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total_weight = mysqli_real_escape_string($conn, $_POST['total_weight']);
    $grand_total = mysqli_real_escape_string($conn, $_POST['grand_total']);
    $transaction_date = mysqli_real_escape_string($conn, $_POST['transaction_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "INSERT INTO transactions (customer_name, customer_phone, shipping_address, courier_service, shipping_cost, payment_method, total_weight, grand_total, transaction_date, status) VALUES ('$customer_name', '$customer_phone', '$shipping_address', '$courier_service', '$shipping_cost', '$payment_method', '$total_weight', '$grand_total', '$transaction_date', '$status')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='transactions_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Transactions</h3>
<div class="card p-4">
    <form action="transactions_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">customer_name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">customer_phone</label>
            <input type="text" name="customer_phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">shipping_address</label>
            <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">courier_service</label>
            <input type="text" name="courier_service" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">shipping_cost</label>
            <input type="number" name="shipping_cost" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">payment_method</label>
            <input type="text" name="payment_method" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">total_weight</label>
            <input type="number" name="total_weight" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">grand_total</label>
            <input type="number" name="grand_total" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">transaction_date</label>
            <input type="datetime-local" name="transaction_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">status</label>
            <select name="status" class="form-select" required>
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
                <option value="Shipped">Shipped</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="transactions_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>