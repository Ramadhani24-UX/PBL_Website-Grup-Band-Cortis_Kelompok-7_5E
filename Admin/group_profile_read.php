<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Group Profile</h3>
    <a href="group_profile_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>profile_id</th>
                <th>group_name</th>
                <th>name_meaning</th>
                <th>agency_name</th>
                <th>agency_website</th>
                <th>agency_contact</th>
                <th>biography</th>
                <th>banner_path</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM group_profile ORDER BY profile_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['profile_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['group_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['name_meaning'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['agency_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['agency_website'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['agency_contact'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['biography'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['banner_path'] ?? '') . "</td>";
        echo "<td>
                <a href='group_profile_update.php?id=" . $row['profile_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='group_profile_delete.php?id=" . $row['profile_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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