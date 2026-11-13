<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $name_meaning = mysqli_real_escape_string($conn, $_POST['name_meaning']);
    $agency_name = mysqli_real_escape_string($conn, $_POST['agency_name']);
    $agency_website = mysqli_real_escape_string($conn, $_POST['agency_website']);
    $agency_contact = mysqli_real_escape_string($conn, $_POST['agency_contact']);
    $biography = mysqli_real_escape_string($conn, $_POST['biography']);
    $banner_path = mysqli_real_escape_string($conn, $_POST['banner_path']);

    $query = "UPDATE group_profile SET group_name='$group_name', name_meaning='$name_meaning', agency_name='$agency_name', agency_website='$agency_website', agency_contact='$agency_contact', biography='$biography', banner_path='$banner_path' WHERE profile_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='group_profile_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM group_profile WHERE profile_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Group Profile</h3>
<div class="card p-4">
    <form action="group_profile_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">group_name</label>
            <input type="text" name="group_name" class="form-control" value="<?= htmlspecialchars($data['group_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">name_meaning</label>
            <input type="text" name="name_meaning" class="form-control" value="<?= htmlspecialchars($data['name_meaning'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_name</label>
            <input type="text" name="agency_name" class="form-control" value="<?= htmlspecialchars($data['agency_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_website</label>
            <input type="text" name="agency_website" class="form-control" value="<?= htmlspecialchars($data['agency_website'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">agency_contact</label>
            <input type="text" name="agency_contact" class="form-control" value="<?= htmlspecialchars($data['agency_contact'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">biography</label>
            <textarea name="biography" class="form-control" rows="3" required><?= htmlspecialchars($data['biography'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">banner_path</label>
            <input type="text" name="banner_path" class="form-control" value="<?= htmlspecialchars($data['banner_path'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="group_profile_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>