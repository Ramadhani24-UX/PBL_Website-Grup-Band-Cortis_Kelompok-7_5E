<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Product Variations</h3>
    <a href="product_variations_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>variation_id</th>
                <th>product_id</th>
                <th>size</th>
                <th>color</th>
                <th>gender_type</th>
                <th>stock</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM product_variations ORDER BY variation_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['variation_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['product_id'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['size'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['color'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['gender_type'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['stock'] ?? '') . "</td>";
        echo "<td>
                <a href='product_variations_update.php?id=" . $row['variation_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='product_variations_delete.php?id=" . $row['variation_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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