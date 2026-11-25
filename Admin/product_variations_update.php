<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id  = mysqli_real_escape_string($conn, $_POST['product_id']);
    $size        = mysqli_real_escape_string($conn, $_POST['size']);
    $color       = mysqli_real_escape_string($conn, $_POST['color']);
    $gender_type = mysqli_real_escape_string($conn, $_POST['gender_type']);
    $stock       = mysqli_real_escape_string($conn, $_POST['stock']);
    $image_path  = trim($_POST['image_path'] ?? '');

    // Jika admin mengunggah file gambar pengganti
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        $ext       = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $file_name = 'var_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $target    = 'uploads/' . $file_name;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target)) {
            $image_path = 'Admin/' . $target;
        }
    }

    $esc_image = mysqli_real_escape_string($conn, $image_path);

    $query = "UPDATE product_variations 
              SET product_id='$product_id', size='$size', color='$color', gender_type='$gender_type', stock='$stock', image_path='$esc_image' 
              WHERE variation_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='product_variations_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM product_variations WHERE variation_id='$id'");
$data = mysqli_fetch_assoc($result);

$preview_src = '';
if (!empty($data['image_path'])) {
    if (file_exists($data['image_path'])) $preview_src = $data['image_path'];
    elseif (file_exists('../' . $data['image_path'])) $preview_src = '../' . $data['image_path'];
    elseif (file_exists('../Assets/images/' . $data['image_path'])) $preview_src = '../Assets/images/' . $data['image_path'];
    elseif (file_exists('uploads/' . $data['image_path'])) $preview_src = 'uploads/' . $data['image_path'];
}

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
        <div class="mb-3">
            <label class="form-label">Upload New Variation Image (Optional)</label>
            <?php if ($preview_src !== '') : ?>
                <div class="mb-2">
                    <img src="<?= htmlspecialchars($preview_src) ?>" alt="Current Image" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #495057;">
                </div>
            <?php endif; ?>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <small class="text-secondary">Unggah file baru jika ingin mengganti gambar variasi ini.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">image_path</label>
            <input type="text" name="image_path" class="form-control" value="<?= htmlspecialchars($data['image_path'] ?? '') ?>">
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="product_variations_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>