<?php
require 'connection.php';
include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Read Data: Tracks</h3>
    <a href="tracks_insert.php" class="btn btn-primary">+ Insert New Data</a>
</div>
<div class="card p-3" style="overflow-x: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr>
                <th>track_id</th>
                <th>album_id</th>
                <th>track_number</th>
                <th>title</th>
                <th>release_date</th>
                <th>cover_path</th>
                <th>spotify_url</th>
                <th>youtube_url</th>
                <th>play_count</th>
                <th>rating</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM tracks ORDER BY track_id DESC");
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['track_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['album_id'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['track_number'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['title'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['release_date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['cover_path'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['spotify_url'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['youtube_url'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['play_count'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['rating'] ?? '') . "</td>";
        echo "<td>
                <a href='tracks_update.php?id=" . $row['track_id'] . "' class='btn btn-sm btn-warning'>Update</a>
                <a href='tracks_delete.php?id=" . $row['track_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this data?\")'>Delete</a>
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