<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Transactions</h3>
    <a href="transactions_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>transaction_id</th>
                <th>customer_name</th>
                <th>customer_phone</th>
                <th>shipping_address</th>
                <th>courier_service</th>
                <th>shipping_cost</th>
                <th>payment_method</th>
                <th>total_weight</th>
                <th>grand_total</th>
                <th>transaction_date</th>
                <th>status</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM transactions ORDER BY transaction_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['transaction_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_phone'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['shipping_address'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['courier_service'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['shipping_cost'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_method'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['total_weight'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['grand_total'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['transaction_date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['status'] ?? '') . "</td>";
        echo "<td>
                <a href='transactions_update.php?id=" . $row['transaction_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='transactions_delete.php?id=" . $row['transaction_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='100%' class='text-center text-secondary py-3'>No data found.</td></tr>";
}
?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>