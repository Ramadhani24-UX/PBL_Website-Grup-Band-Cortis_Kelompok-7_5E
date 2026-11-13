<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $release_type = mysqli_real_escape_string($conn, $_POST['release_type']);
    $release_label = mysqli_real_escape_string($conn, $_POST['release_label']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $cover_path = mysqli_real_escape_string($conn, $_POST['cover_path']);

    $query = "UPDATE albums SET title='$title', release_type='$release_type', release_label='$release_label', release_date='$release_date', description='$description', cover_path='$cover_path' WHERE album_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='albums_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM albums WHERE album_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Albums</h3>
<div class="card p-4">
    <form action="albums_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">release_type</label>
            <select name="release_type" class="form-select" required>
                <option value="EP" <?= ($data['release_type'] == 'EP') ? 'selected' : '' ?>>EP</option>
                <option value="Single" <?= ($data['release_type'] == 'Single') ? 'selected' : '' ?>>Single</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">release_label</label>
            <input type="text" name="release_label" class="form-control" value="<?= htmlspecialchars($data['release_label'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">release_date</label>
            <input type="date" name="release_date" class="form-control" value="<?= htmlspecialchars($data['release_date'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">description</label>
            <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">cover_path</label>
            <input type="text" name="cover_path" class="form-control" value="<?= htmlspecialchars($data['cover_path'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="albums_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>