<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $gender_type = mysqli_real_escape_string($conn, $_POST['gender_type']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    $query = "UPDATE product_variations SET product_id='$product_id', size='$size', color='$color', gender_type='$gender_type', stock='$stock' WHERE variation_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='product_variations_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM product_variations WHERE variation_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Product Variations</h3>
<div class="card p-4">
    <form action="product_variations_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">product_id</label>
            <input type="number" name="product_id" class="form-control" value="<?= htmlspecialchars($data['product_id'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">size</label>
            <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($data['size'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">color</label>
            <input type="text" name="color" class="form-control" value="<?= htmlspecialchars($data['color'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">gender_type</label>
            <select name="gender_type" class="form-select" required>
                <option value="Male" <?= ($data['gender_type'] == 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= ($data['gender_type'] == 'Female') ? 'selected' : '' ?>>Female</option>
                <option value="Unisex" <?= ($data['gender_type'] == 'Unisex') ? 'selected' : '' ?>>Unisex</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">stock</label>
            <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($data['stock'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="product_variations_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>