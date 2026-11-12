<?php
require 'connection.php';

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

    $query = "INSERT INTO tracks (album_id, track_number, title, release_date, cover_path, spotify_url, youtube_url, play_count, rating) VALUES ('$album_id', '$track_number', '$title', '$release_date', '$cover_path', '$spotify_url', '$youtube_url', '$play_count', '$rating')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='tracks_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Tracks</h3>
<div class="card p-4">
    <form action="tracks_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">album_id</label>
            <input type="number" name="album_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">track_number</label>
            <input type="number" name="track_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">release_date</label>
            <input type="date" name="release_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">cover_path</label>
            <input type="text" name="cover_path" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">spotify_url</label>
            <input type="text" name="spotify_url" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">youtube_url</label>
            <input type="text" name="youtube_url" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">play_count</label>
            <input type="number" name="play_count" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">rating</label>
            <input type="text" name="rating" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="tracks_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>