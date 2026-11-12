<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $image_path = mysqli_real_escape_string($conn, $_POST['image_path']);
    $display_order = mysqli_real_escape_string($conn, $_POST['display_order']);

    $query = "INSERT INTO gallery (title, caption, image_path, display_order) VALUES ('$title', '$caption', '$image_path', '$display_order')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='gallery_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Gallery</h3>
<div class="card p-4">
    <form action="gallery_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">caption</label>
            <textarea name="caption" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">image_path</label>
            <input type="text" name="image_path" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">display_order</label>
            <input type="number" name="display_order" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="gallery_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>