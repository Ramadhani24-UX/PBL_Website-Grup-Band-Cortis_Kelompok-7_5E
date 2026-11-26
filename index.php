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

$group_name   = $group['group_name'] ?? 'CORTIS';
$name_meaning = $group['name_meaning'] ?? 'Color Outside The Line';
$biography    = $group['biography'] ?? "An artist cherished for their music, performances, wit, and genuine friendships. What began as a small space to share guides and information has grown into something so much more.\nFrom a simple resource site to a full-fledged community hub – welcome to CORTIS : The Ultimate Guide.\nIt's always been for CORTIS, for COERs, and for anyone discovering them today.🍀";
$banner_img   = resolveImagePath($group['banner_path'] ?? '', 'Assets/images/CORTIS_POSTER.jpg');

// 2. Ambil 3 Data Gallery Utama
$q_gallery = mysqli_query($conn, "SELECT * FROM gallery ORDER BY display_order ASC, image_id ASC LIMIT 3");
$gallery_items = [];
if ($q_gallery) {
    while ($row = mysqli_fetch_assoc($q_gallery)) {
        $gallery_items[] = $row;
    }
}

// 3. Ambil 2 Lagu Terpopuler berdasarkan play_count tertinggi dari tabel tracks untuk Spotify Player
$q_top_tracks = mysqli_query($conn, "SELECT * FROM tracks WHERE spotify_url IS NOT NULL AND spotify_url != '' ORDER BY play_count DESC, track_id ASC LIMIT 2");
$spotify_embeds = [];
if ($q_top_tracks) {
    while ($t = mysqli_fetch_assoc($q_top_tracks)) {
        $embed_url = str_replace('open.spotify.com/track/', 'open.spotify.com/embed/track/', $t['spotify_url']);
        $spotify_embeds[] = [
            'title'      => $t['title'],
            'play_count' => $t['play_count'],
            'embed_url'  => $embed_url
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($group_name) ?>: The Ultimate Guide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #ffffff;
            --accent-color: #00bac6; 
            --text-color: #2b2b2b;
            --primary-font: 'Outfit', 'Helvetica Neue', Arial, sans-serif;
            --title-font: 'Syne', sans-serif;
        }

        body {
            font-family: var(--primary-font);
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--secondary-color);
            width: 100%;
            overflow-x: hidden;
        }

        .top-poster-banner {
            width: 100%;
            background-color: #1a1a1a;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 750px;
        }

        .top-poster-banner img {
            width: 100%;
            height: 100%; 
            object-fit: cover; 
            object-position: center 40%; 
            display: block;
        }

        header {
            background: linear-gradient(to right, #1a1a1a 20%, #005f6b 65%, #008080 100%);
            color: #fff;
            padding: 0.8rem 0;
            position: sticky;
            top: 0; 
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
        }

        .nav-container {
            width: 100%;            
            max-width: 95%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between; 
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box; 
        }

        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 15px; 
        }

        .nav-logo {
            height: 55px;
            width: auto;  
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .logo-text {
            font-family: var(--title-font);
            font-weight: 800;
            font-size: 26px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -1px;
            transition: color 0.2s;
        }

        .logo-link:hover .nav-logo {
            transform: scale(1.05);
        }
        
        .logo-link:hover .logo-text {
            color: var(--accent-color); 
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(4, auto);
            gap: 35px;
            align-items: center;
        }

        nav ul li {
            text-align: center;
        }

        nav ul li a {
            font-family: var(--primary-font);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #e0e0e0;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
            white-space: nowrap;
        }

        nav ul li a:hover, nav ul li a.active {
            color: #fff;
            border-bottom: 3px solid var(--accent-color);
            padding-bottom: 5px;
        }

        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between; 
            gap: 40px; 
            background: transparent !important; 
            box-shadow: none !important; 
            padding: 40px 0;
            margin-top: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .hero-text-side {
            flex: 1.1; 
            text-align: left;
        }

        .hero-image-side {
            flex: 0.9;
            display: flex;
            justify-content: flex-end; 
            align-items: center;
            background: transparent !important;
        }

        .hero-title {
            font-family: var(--title-font);
            font-weight: 800;
            font-size: 5.8em; 
            line-height: 0.95;
            letter-spacing: -3px;
            margin: 0 0 15px 0;
            color: #1a1a1a; 
            text-transform: uppercase;
        }

        .hero-desc {
            font-family: var(--primary-font);
            font-size: 1.65em;
            line-height: 1.5;
            color: #2b2b2b;
            margin-bottom: 18px;
            max-width: 90%; 
            letter-spacing: -0.2px;
            font-weight: 400;
        }

        .hero-desc.sub-hero {
            font-family: var(--title-font);
            font-weight: 800;
            text-transform: uppercase;
            color: #008080; 
            font-size: 2.1em; 
            margin-bottom: 15px;
            letter-spacing: -1px;
        }

        .hero-image-side img {
            width: 100%;
            max-width: 100%; 
            height: auto !important;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08); 
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-top: 30px;
            width: 100%;
            max-width: 320px; 
        }

        .cta-buttons a, .member-btn {
            font-family: var(--primary-font);
            display: block;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            padding: 14px 24px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.15em; 
            border-radius: 30px;
            transition: transform 0.2s, background-color 0.2s, color 0.2s;
            cursor: pointer;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cta-buttons a:hover, .member-btn:hover {
            transform: translateY(-3px);
        }

        .btn-tosca-main { 
            background-color: #008080; 
            color: #ffffff;
        }
        .btn-tosca-main:hover { 
            background-color: #005f6b;
        }

        .btn-dark-main { 
            background-color: #1a1a1a; 
            color: #ffffff;
        }
        .btn-dark-main:hover { 
            background-color: #333333;
        }

        .btn-border-dark { 
            background-color: transparent;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            padding: 12px 22px; 
        }
        .btn-border-dark:hover { 
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .container {
            width: 100%;
            max-width: 90%; 
            margin: 10px auto;
            padding: 0 20px;   
            min-height: 50vh;
            box-sizing: border-box;
        }

        .page-content {
            display: none;
            background: #fff;
            padding: 40px; 
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.5s ease-in-out;
        }

        #home-page.page-content {
            background: transparent !important;
            box-shadow: none !important;
            padding: 0;
        }

        .page-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2.section-title {
            font-family: var(--title-font);
            font-size: 2.4em; 
            color: var(--primary-color);
            border-bottom: 3px solid #008080;
            padding-bottom: 10px;
            margin-top: 0;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 30px;
            margin-top: 20px;
            width: 100%;
        }

        .member-wrapper {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        .member-img-box {
            width: 100%;
            height: 420px; 
            background-color: #e0e0e0;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin-bottom: 15px;
        }

        .spotify-header {
            margin-top: 80px;
            text-align: center;
        }

        .spotify-header h2.section-title {
            font-family: var(--title-font);
            font-weight: 800;
            font-size: 5.8em; 
            line-height: 0.95;
            letter-spacing: -3px;
            margin: 0 0 15px 0;
            color: #1a1a1a; 
            text-transform: uppercase;
            border-bottom: none; 
            padding-bottom: 0;
        }

        .spotify-player-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 30px; 
            margin: 60px auto; 
            width: 100%; 
            justify-content: center;
        }

        .spotify-frame {
            width: 100%; 
            height: 300px; 
            border: none;
            border-radius: 12px;
        }

        .cookie-banner {
            font-family: var(--primary-font);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #222;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 0.95em;
            z-index: 1000;
            box-sizing: border-box;
        }

        .cookie-banner button {
            font-family: var(--primary-font);
            background: white;
            color: #222;
            border: none;
            padding: 8px 15px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        footer {
            font-family: var(--primary-font);
            background: linear-gradient(to right, #1a1a1a 20%, #005f6b 65%, #008080 100%);
            color: #ccc;
            text-align: center;
            padding: 30px 20px;
            font-size: 0.95em;
            margin-top: 40px;
            margin-bottom: 0;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    
    <!-- POSTER BANNER DARI DATABASE group_profile -->
    <div class="top-poster-banner">
        <img src="<?= htmlspecialchars($banner_img) ?>" alt="<?= htmlspecialchars($group_name) ?> Poster">
    </div>

    <header>
        <div class="nav-container">
            <a href="index.php" class="nav-link logo-link" data-target="home-page">
                <img src="Assets/images/CORTIS_Logo.jpg" alt="CORTIS Logo" class="nav-logo">
                <span class="logo-text">COERZONE</span>
            </a>
            <nav>
                <ul>
                    <li><a href="index.php" class="nav-link active" data-target="home-page">Home</a></li>
                    <li><a href="About.php">About</a></li>
                    <li><a href="The_Music.php">#Stream Cortis</a></li>
                    <li><a href="Store.php">Store</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div id="home-page" class="page-content active">
            
            <div class="hero-container">
                <div class="hero-text-side">
                    <h1 class="hero-title">Hello COER!</h1>
                    <p class="hero-desc sub-hero"><?= htmlspecialchars($group_name) ?> : <?= htmlspecialchars($name_meaning) ?></p>
                    <?php
                    foreach (explode("\n", trim($biography)) as $p) {
                        if (trim($p) !== '') {
                            echo '<p class="hero-desc">' . htmlspecialchars(trim($p)) . '</p>';
                        }
                    }
                    ?>
                    
                    <div class="cta-buttons">
                        <a href="About.php" class="btn-tosca-main">Baby Coer? Start here!</a>
                        <a href="The_Music.php" class="btn-dark-main">#STREAM CORTIS</a>
                        <a href="Store.php" class="btn-border-dark">Support Today</a>
                    </div>
                </div>
                
                <div class="hero-image-side">
                    <img src="Assets/images/CORTIS.jpeg" alt="CORTIS Group Photo">
                </div>
            </div>

            <!-- BAGIAN GALERI DARI DATABASE gallery -->
            <section id="members" style="margin-top: 40px; margin-bottom: 20px;">
                <div class="grid-3">
                    <?php
                    $cards_config = [
                        ['default_img' => 'Assets/images/CORTIS_1.GIF', 'default_title' => 'Baby Coer', 'link' => 'About.php', 'btn_class' => 'btn-tosca-main'],
                        ['default_img' => 'Assets/images/CORTIS_2.GIF', 'default_title' => 'The Music', 'link' => 'The_Music.php', 'btn_class' => 'btn-dark-main'],
                        ['default_img' => 'Assets/images/CORTIS_3.GIF', 'default_title' => 'Store', 'link' => 'Store.php', 'btn_class' => 'btn-border-dark'],
                    ];
                    for ($i = 0; $i < 3; $i++) :
                        $img_src = isset($gallery_items[$i]) ? resolveImagePath($gallery_items[$i]['image_path'], $cards_config[$i]['default_img']) : $cards_config[$i]['default_img'];
                        $btn_label = !empty($gallery_items[$i]['title']) ? $gallery_items[$i]['title'] : $cards_config[$i]['default_title'];
                    ?>
                    <div class="member-wrapper">
                        <img src="<?= htmlspecialchars($img_src) ?>" alt="<?= htmlspecialchars($btn_label) ?>" class="member-img-box">
                        <a href="<?= $cards_config[$i]['link'] ?>" class="member-btn <?= $cards_config[$i]['btn_class'] ?>"><?= htmlspecialchars($btn_label) ?></a>
                    </div>
                    <?php endfor; ?>
                </div>
            </section>
        </div>

        <!-- Kotak Audio Player (Diurutkan berdasarkan play_count tertinggi dari tabel tracks) -->
        <div class="spotify-header">
            <h2 class="section-title">Listen to <?= htmlspecialchars($group_name) ?> </h2>
            <h2>Check out our latest and most popular tracks directly on Spotify</h2>
        </div>

        <div class="spotify-player-container">
            <?php if (!empty($spotify_embeds)) : ?>
                <?php foreach ($spotify_embeds as $sp) : ?>
                    <iframe class="spotify-frame"
                        src="<?= htmlspecialchars($sp['embed_url']) ?>"
                        frameBorder="0">
                    </iframe>
                <?php endforeach; ?>
            <?php else : ?>
                <iframe class="spotify-frame"
                    src="https://open.spotify.com/embed/track/4ecdsGz3Hg6TKPwQ0ZOdJz?utm_source=generator&si=a2bfa6203b5c4a35"  
                    frameBorder="0">
                </iframe>

                <iframe class="spotify-frame"
                    src="https://open.spotify.com/embed/track/2fCwv2ppU5nTRTckomIGsd?utm_source=generator&si=def6346139ce47e2"  
                    frameBorder="0">
                </iframe>
            <?php endif; ?>
        </div>
    </div> 

    <div class="cookie-banner" id="cookieBanner">
        We use cookies. This website uses cookies to ensure you get the best experience.
        <button onclick="closeCookie()">Accept all</button> 
        <button onclick="closeCookie()">Reject all</button>
    </div>

    <footer>
        <p><em>Built with love by Fans, for Fans — always united for <?= htmlspecialchars($group_name) ?>.</em></p>
        <p>© 2026 Just Cortis | Unofficial fan-made website.</p>
    </footer>

    <script>
        function closeCookie() {
            document.getElementById('cookieBanner').style.display = 'none';
        }
    </script>
</body>

</html>