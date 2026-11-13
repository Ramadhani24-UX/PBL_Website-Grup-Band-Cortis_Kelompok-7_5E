<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $image_path = mysqli_real_escape_string($conn, $_POST['image_path']);
    $display_order = mysqli_real_escape_string($conn, $_POST['display_order']);

    $query = "UPDATE gallery SET title='$title', caption='$caption', image_path='$image_path', display_order='$display_order' WHERE image_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='gallery_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM gallery WHERE image_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Gallery</h3>
<div class="card p-4">
    <form action="gallery_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">caption</label>
            <textarea name="caption" class="form-control" rows="3" required><?= htmlspecialchars($data['caption'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">image_path</label>
            <input type="text" name="image_path" class="form-control" value="<?= htmlspecialchars($data['image_path'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">display_order</label>
            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($data['display_order'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="gallery_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>