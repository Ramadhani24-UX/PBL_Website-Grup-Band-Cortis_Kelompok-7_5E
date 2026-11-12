<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Member Profile</h3>
    <a href="member_profile_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>member_id</th>
                <th>stage_name</th>
                <th>full_name</th>
                <th>english_name</th>
                <th>position</th>
                <th>birth_date</th>
                <th>nationality</th>
                <th>height_cm</th>
                <th>mbti</th>
                <th>birth_place</th>
                <th>photo_path</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM member_profile ORDER BY member_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['member_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['stage_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['full_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['english_name'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['position'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['birth_date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['nationality'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['height_cm'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['mbti'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['birth_place'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['photo_path'] ?? '') . "</td>";
        echo "<td>
                <a href='member_profile_update.php?id=" . $row['member_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='member_profile_delete.php?id=" . $row['member_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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