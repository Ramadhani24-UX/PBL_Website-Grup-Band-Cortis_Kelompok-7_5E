<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $image_path = mysqli_real_escape_string($conn, $_POST['image_path']);
    $weight_gram = mysqli_real_escape_string($conn, $_POST['weight_gram']);

    $query = "INSERT INTO products (product_name, description, price, image_path, weight_gram) VALUES ('$product_name', '$description', '$price', '$image_path', '$weight_gram')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='products_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Products</h3>
<div class="card p-4">
    <form action="products_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">product_name</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">price</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">image_path</label>
            <input type="text" name="image_path" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">weight_gram</label>
            <input type="number" name="weight_gram" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="products_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>