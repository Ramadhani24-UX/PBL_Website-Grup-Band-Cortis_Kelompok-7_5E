<?php
require_once 'Admin/connection.php';

function resolveImagePath($path, $default) {
    if (empty($path)) return $default;
    if (file_exists($path)) return $path;
    if (file_exists('Assets/images/' . $path)) return 'Assets/images/' . $path;
    if (file_exists('Admin/' . $path)) return 'Admin/' . $path;
    if (file_exists('Admin/uploads/' . $path)) return 'Admin/uploads/' . $path;
    return $default;
}

// 1. Ambil Data Group Profile
$q_group = mysqli_query($conn, "SELECT * FROM group_profile LIMIT 1");
$group   = ($q_group && mysqli_num_rows($q_group) > 0) ? mysqli_fetch_assoc($q_group) : null;

$group_name     = $group['group_name'] ?? 'CORTIS';
$name_meaning   = $group['name_meaning'] ?? 'Color Outside The Lines';
$agency_name    = $group['agency_name'] ?? 'Big Hit Music (a subsidiary of HYBE)';
$agency_website = $group['agency_website'] ?? '';
$agency_contact = $group['agency_contact'] ?? '';
$biography      = $group['biography'] ?? "CORTIS is a five-member group formed with the vision of creating meaningful music and unforgettable experiences.\nThrough innovative concepts, strong performances, and authentic music, CORTIS continues to connect with audiences around the world.\nTheir journey is defined by passion, creativity, and a commitment to pushing artistic boundaries.";

// 2. Ambil Data Member Profile
$q_members = mysqli_query($conn, "SELECT * FROM member_profile ORDER BY member_id ASC");

// 3. Ambil Data Gallery
$q_gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY display_order ASC, image_id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About <?= htmlspecialchars($group_name) ?></title>
    <!-- Menyesuaikan path CSS ke folder Assets -->
    <link rel="stylesheet" href="Assets/css/About.css">
    <style>
        /* Styling Lightbox Gallery tanpa mengubah tata letak asli About.css */
        .gallery-grid img {
            cursor: pointer;
            transition: transform 0.25s ease;
        }
        .gallery-grid img:hover {
            transform: scale(1.03);
        }
        .lightbox-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0, 0, 0, 0.88);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }
        .lightbox-overlay img {
            max-width: 90%;
            max-height: 80vh;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0, 186, 198, 0.5);
            object-fit: contain;
        }
        .lightbox-caption {
            color: #ffffff;
            margin-top: 14px;
            font-size: 1rem;
            text-align: center;
            max-width: 700px;
            line-height: 1.5;
        }
        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #ffffff;
            font-size: 38px;
            cursor: pointer;
            background: none;
            border: none;
            line-height: 1;
        }
    </style>
</head>
<body>

<!-- HERO -->
<header class="hero">
    <div class="hero-content">
        <h1>ABOUT <?= htmlspecialchars(strtoupper($group_name)) ?></h1>
        <p>
            <?= htmlspecialchars($group_name) ?> is a five-member South Korean boy group formed by
            <?= htmlspecialchars($agency_name) ?>.
            The name is an abbreviation of
            "<?= htmlspecialchars($name_meaning) ?>" and represents
            their limitless creativity, authenticity,
            and commitment to breaking societal norms.
        </p>
    </div>
</header>

<!-- NAVBAR -->
<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="About.php">About</a></li>
        <li><a href="The_Music.php">#Stream Cortis</a></li>
        <li><a href="Store.php">Store</a></li>
    </ul>
</nav>

<!-- PROFILE -->
<section class="group-bio">
    <h2 class="section-title">PROFILE & BIOGRAPHY</h2>
    <div class="bio-container">
        <div class="bio-image">
            <img src="Assets/images/fullmember.jpg" alt="<?= htmlspecialchars($group_name) ?>">
        </div>
        <div class="bio-text">
            <?php
            $bio_lines = explode("\n", trim($biography));
            foreach ($bio_lines as $line) {
                if (trim($line) !== '') {
                    echo '<p>' . htmlspecialchars(trim($line)) . '</p>';
                }
            }
            ?>
            <?php if (!empty($agency_name) || !empty($agency_website) || !empty($agency_contact)) : ?>
                <p>
                    <strong>Agency:</strong> <?= htmlspecialchars($agency_name) ?>
                    <?php if (!empty($agency_website)) : ?>
                        | <a href="<?= htmlspecialchars($agency_website) ?>" target="_blank" style="color: #008080; font-weight: bold;">Official Website</a>
                    <?php endif; ?>
                    <?php if (!empty($agency_contact)) : ?>
                        | <strong>Contact:</strong> <?= htmlspecialchars($agency_contact) ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- MEMBERS -->
<section class="members">
    <h2 class="section-title">MEET THE MEMBERS</h2>
    <div class="member-scroll">

        <?php if ($q_members && mysqli_num_rows($q_members) > 0) : ?>
            <?php $idx = 1; while ($m = mysqli_fetch_assoc($q_members)) : 
                $default_member_img = "Assets/images/member" . (($idx <= 5) ? $idx : 1) . ".jpg";
                $member_photo = resolveImagePath($m['photo_path'], $default_member_img);
                $birth_formatted = !empty($m['birth_date']) ? date('F j, Y', strtotime($m['birth_date'])) : '';
            ?>
            <div class="member-card">
                <img src="<?= htmlspecialchars($member_photo) ?>" alt="<?= htmlspecialchars($m['stage_name']) ?>">
                <div class="member-content">
                    <h3><?= htmlspecialchars($m['stage_name']) ?></h3>
                    <span><?= htmlspecialchars($m['position'] ?? 'Member') ?></span>
                    <ul class="bio-list">
                        <?php if (!empty($m['full_name'])) : ?>
                            <li><strong>Full Name:</strong> <?= htmlspecialchars($m['full_name']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($m['english_name'])) : ?>
                            <li><strong>English Name:</strong> <?= htmlspecialchars($m['english_name']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($birth_formatted)) : ?>
                            <li><strong>Birth:</strong> <?= htmlspecialchars($birth_formatted) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($m['nationality'])) : ?>
                            <li><strong>Nationality:</strong> <?= htmlspecialchars($m['nationality']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($m['height_cm'])) : ?>
                            <li><strong>Height:</strong> <?= htmlspecialchars($m['height_cm']) ?> cm</li>
                        <?php endif; ?>
                        <?php if (!empty($m['mbti'])) : ?>
                            <li><strong>MBTI:</strong> <?= htmlspecialchars($m['mbti']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($m['birth_place'])) : ?>
                            <li><strong>Place:</strong> <?= htmlspecialchars($m['birth_place']) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php $idx++; endwhile; ?>
        <?php else : ?>
            <!-- Fallback jika tabel member_profile masih kosong -->
            <div class="member-card">
                <img src="Assets/images/member1.jpg" alt="Martin">
                <div class="member-content">
                    <h3>Martin</h3>
                    <span>Leader & Main Rapper</span>
                    <ul class="bio-list">
                        <li><strong>Full Name:</strong> Martin Edwards Park</li>
                        <li><strong>Birth:</strong> March 20, 2008</li>
                        <li><strong>Nationality:</strong> Canadian-Korean</li>
                        <li><strong>Height:</strong> 190.5 cm</li>
                    </ul>
                </div>
            </div>
            <div class="member-card">
                <img src="Assets/images/member2.jpg" alt="James">
                <div class="member-content">
                    <h3>James</h3>
                    <span>Main Dancer & Rapper</span>
                    <ul class="bio-list">
                        <li><strong>Real Name:</strong> Chao Yu-fan</li>
                        <li><strong>Birth:</strong> October 14, 2005</li>
                        <li><strong>Nationality:</strong> Thai-Taiwanese</li>
                        <li><strong>Height:</strong> 178 cm</li>
                    </ul>
                </div>
            </div>
            <div class="member-card">
                <img src="Assets/images/member3.jpg" alt="Seonghyeon">
                <div class="member-content">
                    <h3>Seonghyeon</h3>
                    <span>Main Vocalist</span>
                    <ul class="bio-list">
                        <li><strong>English Name:</strong> Sean</li>
                        <li><strong>Birth:</strong> Jan 13, 2009</li>
                        <li><strong>Height:</strong> 175 cm</li>
                        <li><strong>MBTI:</strong> INTP</li>
                    </ul>
                </div>
            </div>
            <div class="member-card">
                <img src="Assets/images/member4.jpg" alt="Keonho">
                <div class="member-content">
                    <h3>Keonho</h3>
                    <span>Vocalist & Visual</span>
                    <ul class="bio-list">
                        <li><strong>Full Name:</strong> Ahn Geon-ho</li>
                        <li><strong>Birth:</strong> Feb 14, 2009</li>
                        <li><strong>Color:</strong> Yellow</li>
                        <li><strong>Role:</strong> Maknae</li>
                    </ul>
                </div>
            </div>
            <div class="member-card">
                <img src="Assets/images/member5.jpg" alt="Juhoon">
                <div class="member-content">
                    <h3>Juhoon</h3>
                    <span>Vocalist</span>
                    <ul class="bio-list">
                        <li><strong>Full Name:</strong> Kim Ju-hoon</li>
                        <li><strong>Birth:</strong> Jan 3, 2008</li>
                        <li><strong>MBTI:</strong> ISFP</li>
                        <li><strong>Place:</strong> Seoul</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- GALLERY WITH LIGHTBOX -->
<section class="gallery">
    <h2 class="section-title">EXCLUSIVE GALLERY</h2>
    <div class="gallery-grid">
        <?php if ($q_gallery && mysqli_num_rows($q_gallery) > 0) : ?>
            <?php while ($g = mysqli_fetch_assoc($q_gallery)) : 
                $gal_img = resolveImagePath($g['image_path'], 'Assets/images/redred.jpg');
                $gal_cap = (!empty($g['title']) ? $g['title'] : '') . (!empty($g['caption']) ? ' — ' . $g['caption'] : '');
            ?>
                <img src="<?= htmlspecialchars($gal_img) ?>" 
                     alt="<?= htmlspecialchars($g['title'] ?? 'Gallery') ?>" 
                     onclick="openLightbox(this.src, <?= htmlspecialchars(json_encode(trim($gal_cap))) ?>)">
            <?php endwhile; ?>
        <?php else : ?>
            <img src="Assets/images/redred.jpg" alt="Gallery 1" onclick="openLightbox(this.src, 'Gallery 1')">
            <img src="Assets/images/go.jpg" alt="Gallery 2" onclick="openLightbox(this.src, 'Gallery 2')">
            <img src="Assets/images/fashion.jpg" alt="Gallery 3" onclick="openLightbox(this.src, 'Gallery 3')">
            <img src="Assets/images/color.jpg" alt="Gallery 4" onclick="openLightbox(this.src, 'Gallery 4')">
            <img src="Assets/images/outside.jpg" alt="Gallery 5" onclick="openLightbox(this.src, 'Gallery 5')">
            <img src="Assets/images/lines.jpg" alt="Gallery 6" onclick="openLightbox(this.src, 'Gallery 6')">
        <?php endif; ?>
    </div>
</section>

<!-- LIGHTBOX MODAL -->
<div id="lightboxModal" class="lightbox-overlay" onclick="closeLightbox()">
    <button type="button" class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <img id="lightboxImg" src="" alt="Gallery Preview">
    <div id="lightboxCaption" class="lightbox-caption"></div>
</div>

<footer>
    <p>© 2026 <?= htmlspecialchars($group_name) ?>. ALL RIGHTS RESERVED.</p>
</footer>

<script>
function openLightbox(src, caption) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightboxModal').style.display = 'flex';
}
function closeLightbox() {
    document.getElementById('lightboxModal').style.display = 'none';
}
</script>

</body>
</html>