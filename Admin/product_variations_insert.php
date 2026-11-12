<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $gender_type = mysqli_real_escape_string($conn, $_POST['gender_type']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    $query = "INSERT INTO product_variations (product_id, size, color, gender_type, stock) VALUES ('$product_id', '$size', '$color', '$gender_type', '$stock')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='product_variations_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Product Variations</h3>
<div class="card p-4">
    <form action="product_variations_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">product_id</label>
            <input type="number" name="product_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">size</label>
            <input type="text" name="size" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">color</label>
            <input type="text" name="color" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">gender_type</label>
            <select name="gender_type" class="form-select" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Unisex">Unisex</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="product_variations_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>