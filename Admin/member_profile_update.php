<?php
require 'connection.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stage_name = mysqli_real_escape_string($conn, $_POST['stage_name']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $english_name = mysqli_real_escape_string($conn, $_POST['english_name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $height_cm = mysqli_real_escape_string($conn, $_POST['height_cm']);
    $mbti = mysqli_real_escape_string($conn, $_POST['mbti']);
    $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);
    $photo_path = mysqli_real_escape_string($conn, $_POST['photo_path']);

    $query = "UPDATE member_profile SET stage_name='$stage_name', full_name='$full_name', english_name='$english_name', position='$position', birth_date='$birth_date', nationality='$nationality', height_cm='$height_cm', mbti='$mbti', birth_place='$birth_place', photo_path='$photo_path' WHERE member_id='$id'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data successfully updated!'); window.location='member_profile_read.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM member_profile WHERE member_id='$id'");
$data = mysqli_fetch_assoc($result);

include 'header.php';
?>
<h3 class="mb-4">Update Data: Member Profile</h3>
<div class="card p-4">
    <form action="member_profile_update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">stage_name</label>
            <input type="text" name="stage_name" class="form-control" value="<?= htmlspecialchars($data['stage_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">full_name</label>
            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($data['full_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">english_name</label>
            <input type="text" name="english_name" class="form-control" value="<?= htmlspecialchars($data['english_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">position</label>
            <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($data['position'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">birth_date</label>
            <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($data['birth_date'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">nationality</label>
            <input type="text" name="nationality" class="form-control" value="<?= htmlspecialchars($data['nationality'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">height_cm</label>
            <input type="number" name="height_cm" class="form-control" value="<?= htmlspecialchars($data['height_cm'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">mbti</label>
            <input type="text" name="mbti" class="form-control" value="<?= htmlspecialchars($data['mbti'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">birth_place</label>
            <input type="text" name="birth_place" class="form-control" value="<?= htmlspecialchars($data['birth_place'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">photo_path</label>
            <input type="text" name="photo_path" class="form-control" value="<?= htmlspecialchars($data['photo_path'] ?? '') ?>" required>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="member_profile_read.php" class="btn btn-secondary px-4 ms-2">Cancel</a>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>