<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $album_id = mysqli_real_escape_string($conn, $_POST['album_id']);
    $track_number = mysqli_real_escape_string($conn, $_POST['track_number']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $cover_path = mysqli_real_escape_string($conn, $_POST['cover_path']);
    $spotify_url = mysqli_real_escape_string($conn, $_POST['spotify_url']);
    $youtube_url = mysqli_real_escape_string($conn, $_POST['youtube_url']);
    $play_count = mysqli_real_escape_string($conn, $_POST['play_count']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

    $query = "UPDATE tracks SET album_id='$album_id', track_number='$track_number', title='$title', release_date='$release_date', cover_path='$cover_path', spotify_url='$spotify_url', youtube_url='$youtube_url', play_count='$play_count', rating='$rating' WHERE track_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='tracks_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM tracks WHERE track_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Tracks</h3>
<div class="card p-4">
    <form action="tracks_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">album_id</label>
            <input type="number" name="album_id" class="form-control" value="<?= htmlspecialchars($data['album_id'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">track_number</label>
            <input type="number" name="track_number" class="form-control" value="<?= htmlspecialchars($data['track_number'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">release_date</label>
            <input type="date" name="release_date" class="form-control" value="<?= htmlspecialchars($data['release_date'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">cover_path</label>
            <input type="text" name="cover_path" class="form-control" value="<?= htmlspecialchars($data['cover_path'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">spotify_url</label>
            <input type="text" name="spotify_url" class="form-control" value="<?= htmlspecialchars($data['spotify_url'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">youtube_url</label>
            <input type="text" name="youtube_url" class="form-control" value="<?= htmlspecialchars($data['youtube_url'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">play_count</label>
            <input type="number" name="play_count" class="form-control" value="<?= htmlspecialchars($data['play_count'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">rating</label>
            <input type="text" name="rating" class="form-control" value="<?= htmlspecialchars($data['rating'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="tracks_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>