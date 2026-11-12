<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Albums</h3>
    <a href="albums_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>album_id</th>
                <th>title</th>
                <th>release_type</th>
                <th>release_label</th>
                <th>release_date</th>
                <th>description</th>
                <th>cover_path</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM albums ORDER BY album_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['album_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['release_type'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['release_label'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['release_date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['description'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['cover_path'] ?? '') . "</td>";
        echo "<td>
                <a href='albums_update.php?id=" . $row['album_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='albums_delete.php?id=" . $row['album_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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