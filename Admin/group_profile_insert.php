<?php
require 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $name_meaning = mysqli_real_escape_string($conn, $_POST['name_meaning']);
    $agency_name = mysqli_real_escape_string($conn, $_POST['agency_name']);
    $agency_website = mysqli_real_escape_string($conn, $_POST['agency_website']);
    $agency_contact = mysqli_real_escape_string($conn, $_POST['agency_contact']);
    $biography = mysqli_real_escape_string($conn, $_POST['biography']);
    $banner_path = mysqli_real_escape_string($conn, $_POST['banner_path']);

    $query = "INSERT INTO group_profile (group_name, name_meaning, agency_name, agency_website, agency_contact, biography, banner_path) VALUES ('$group_name', '$name_meaning', '$agency_name', '$agency_website', '$agency_contact', '$biography', '$banner_path')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully inserted!'); window.location='group_profile_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
include 'header.php';
?>
<h3 class="mb-4">Insert Data: Group Profile</h3>
<div class="card p-4">
    <form action="group_profile_insert.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">group_name</label>
            <input type="text" name="group_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">name_meaning</label>
            <input type="text" name="name_meaning" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_name</label>
            <input type="text" name="agency_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_website</label>
            <input type="text" name="agency_website" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_contact</label>
            <input type="text" name="agency_contact" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">biography</label>
            <textarea name="biography" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">banner_path</label>
            <input type="text" name="banner_path" class="form-control" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Insert Data</button>
            <a href="group_profile_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>