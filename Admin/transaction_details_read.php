<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Transaction Details</h3>
    <a href="transaction_details_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>detail_id</th>
                <th>transaction_id</th>
                <th>variation_id</th>
                <th>quantity</th>
                <th>subtotal_price</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM transaction_details ORDER BY detail_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['detail_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['transaction_id'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['variation_id'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['subtotal_price'] ?? '') . "</td>";
        echo "<td>
                <a href='transaction_details_update.php?id=" . $row['detail_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='transaction_details_delete.php?id=" . $row['detail_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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