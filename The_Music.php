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

// 1. Ambil daftar semua album untuk opsi dropdown filter
$q_album_list = mysqli_query($conn, "SELECT album_id, title, release_type FROM albums ORDER BY release_date ASC, album_id ASC");

// 2. Tangkap parameter filter & search (GET)
$selected_album = isset($_GET['album_id']) ? (int) $_GET['album_id'] : 0;
$search_query   = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_esc     = mysqli_real_escape_string($conn, $search_query);

// 3. Query album yang ditampilkan
$sql_albums = "SELECT * FROM albums";
if ($selected_album > 0) {
    $sql_albums .= " WHERE album_id = $selected_album";
}
$sql_albums .= " ORDER BY release_date ASC, album_id ASC";
$q_albums = mysqli_query($conn, $sql_albums);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortis - The Music</title>
    
    <style>
        /* --- Base Settings --- */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
            background: linear-gradient(rgba(10, 10, 15, 0.85), rgba(10, 10, 15, 0.95)), url('Assets/images/Cover.png') no-repeat center center fixed;
            background-size: cover;
        }

        /* --- Navigation Bar --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: rgba(10, 10, 15, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: 3px;
        }

        .bracket-left { color: #0ff; text-shadow: 0 0 5px #0ff; }
        .bracket-right { color: #f0f; text-shadow: 0 0 5px #f0f; }
        
        .logo-text {
            background: linear-gradient(to right, #0ff, #a855f7, #f0f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: #0ff;
            text-shadow: 0 0 8px #0ff;
        }

        .separator {
            color: #555;
            font-weight: normal;
        }

        .nav-links a.active {
            color: #0ff;
            border-bottom: 2px solid #0ff;
            padding-bottom: 3px;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.6);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 20px;
                padding: 15px 20px;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
        }

        /* --- Main Container --- */
        #the-music {
            padding: 60px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #fff; 
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 0 0 5px #0ff, 0 0 10px #0ff, 0 0 20px #0ff, 0 0 40px #0ff; 
        }

        .section-header p {
            color: #d4d4d8;
            font-size: 1.1rem;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        /* --- Search & Dropdown Filter Bar --- */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
            background-color: rgba(20, 20, 30, 0.78);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 18px 22px;
            border-radius: 12px;
            border: 1px solid #0ff;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
        }

        .filter-bar input,
        .filter-bar select {
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #a855f7;
            background-color: rgba(15, 15, 22, 0.95);
            color: #ffffff;
            font-size: 0.95rem;
            min-width: 230px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            border-color: #0ff;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        .filter-bar button,
        .filter-bar a.reset-btn {
            padding: 10px 22px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-bar button {
            background: linear-gradient(to right, #0ff, #a855f7);
            color: #0a0a0f;
            box-shadow: 0 0 12px rgba(0, 255, 255, 0.4);
        }

        .filter-bar button:hover,
        .filter-bar a.reset-btn:hover {
            transform: translateY(-2px);
        }

        .filter-bar a.reset-btn {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        /* --- Album Card Layout --- */
        .album-card {
            background-color: rgba(20, 20, 25, 0.7);
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 50px;
            display: flex;
            flex-direction: column;
            gap: 30px;
            border: 1px solid #a855f7;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4), inset 0 0 15px rgba(168, 85, 247, 0.2);
            transition: all 0.4s ease;
        }

        .album-card:hover {
            transform: translateY(-5px);
            border-color: #0ff;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.7), inset 0 0 20px rgba(0, 255, 255, 0.3);
        }

        @media (min-width: 800px) {
            .album-card {
                flex-direction: row;
            }
        }

        /* --- Album Info (Left Side) --- */
        .album-info {
            flex: 0 0 280px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .album-cover {
            width: 100%;
            max-width: 280px;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
            background: #1a1a1a;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .album-title {
            font-size: 1.6rem;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #fff;
            line-height: 1.2;
            text-shadow: 0 0 5px #f0f, 0 0 15px #f0f;
        }

        .album-meta {
            font-size: 0.95rem;
            color: #0ff;
            margin: 0 0 15px 0;
            font-weight: 600;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
        }

        .album-desc {
            font-size: 0.9rem;
            color: #e4e4e7;
            line-height: 1.6;
            margin: 0;
            text-align: justify;
        }

        /* --- Tracklist (Right Side) --- */
        .tracklist {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            justify-content: center;
        }

        .track-item {
            background-color: rgba(30, 30, 35, 0.8);
            border-radius: 8px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; 
            gap: 15px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .track-item:hover {
            border-color: #f0f;
            box-shadow: 0 0 10px rgba(255, 0, 255, 0.5);
            background-color: rgba(40, 40, 50, 0.9);
        }

        .track-details-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1 1 200px; 
            min-width: 0; 
        }

        .track-cover {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
            background-color: #2a2a2a;
            flex-shrink: 0; 
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .track-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            min-width: 0; 
        }

        .track-name {
            font-size: 1rem;
            font-weight: 500;
            white-space: normal; 
            word-wrap: break-word;
            line-height: 1.3;
            transition: color 0.3s ease;
        }
        
        .track-item:hover .track-name {
            color: #0ff;
            text-shadow: 0 0 5px rgba(0, 255, 255, 0.6);
        }

        .track-date {
            font-size: 0.75rem;
            color: #a1a1aa;
        }

        /* --- Custom Media Buttons --- */
        .media-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-spotify {
            background-color: #1DB954; 
            box-shadow: 0 4px 10px rgba(29, 185, 84, 0.3);
            border: 1px solid #1ed760;
        }
        
        .btn-spotify:hover {
            box-shadow: 0 6px 15px rgba(29, 185, 84, 0.6);
        }

        .btn-youtube {
            background-color: #FF0000; 
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.3);
            border: 1px solid #ff4d4d;
        }

        .btn-youtube:hover {
            box-shadow: 0 6px 15px rgba(255, 0, 0, 0.6);
        }

        @media (max-width: 650px) {
            .track-item {
                flex-direction: column;
                align-items: stretch;
            }
            .track-details-wrapper {
                width: 100%;
                margin-bottom: 5px;
            }
            .media-buttons {
                justify-content: flex-start;
                width: 100%;
            }
            .btn {
                flex: 1; 
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <span class="bracket-left">[</span><span class="logo-text">COERZONE</span><span class="bracket-right">]</span>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <span class="separator">|</span>
            <a href="About.php">About</a>
            <span class="separator">|</span>
            <a href="Store.php">Store</a>
            <span class="separator">|</span>
            <a href="The_Music.php" class="active">The Music</a>
        </div>
    </nav>

    <section id="the-music">
        <div class="section-header">
            <h2>The Music</h2>
            <p>Explore the complete discography of CORTIS.</p>
        </div>

        <!-- FITUR SEARCH LAGU & DROPDOWN FILTER ALBUMS -->
        <form method="GET" action="The_Music.php" class="filter-bar">
            <input type="text" name="search" placeholder="Search track title..." value="<?= htmlspecialchars($search_query) ?>">
            <select name="album_id">
                <option value="0">-- All Albums & Singles --</option>
                <?php if ($q_album_list) : ?>
                    <?php while ($opt = mysqli_fetch_assoc($q_album_list)) : ?>
                        <option value="<?= (int)$opt['album_id'] ?>" <?= ($selected_album === (int)$opt['album_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($opt['title']) ?> (<?= htmlspecialchars($opt['release_type']) ?>)
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
            <button type="submit">Search / Filter</button>
            <?php if ($selected_album > 0 || $search_query !== '') : ?>
                <a href="The_Music.php" class="reset-btn">Reset</a>
            <?php endif; ?>
        </form>

        <?php 
        $found_any = false;
        if ($q_albums && mysqli_num_rows($q_albums) > 0) : 
            while ($album = mysqli_fetch_assoc($q_albums)) : 
                $album_id = (int) $album['album_id'];
                
                $sql_tracks = "SELECT * FROM tracks WHERE album_id = $album_id";
                if ($search_query !== '') {
                    $sql_tracks .= " AND title LIKE '%$search_esc%'";
                }
                $sql_tracks .= " ORDER BY track_number ASC, track_id ASC";
                $q_tracks = mysqli_query($conn, $sql_tracks);

                // Jika sedang mencari judul lagu tertentu dan tidak ada lagu yang cocok di album ini, lewati album
                if ($search_query !== '' && (!$q_tracks || mysqli_num_rows($q_tracks) === 0)) {
                    continue;
                }
                $found_any = true;

                $album_cover = resolveImagePath($album['cover_path'], 'Assets/images/Cover.png');
                $album_date  = !empty($album['release_date']) ? date('M j, Y', strtotime($album['release_date'])) : '';
                $meta_label  = !empty($album['release_label']) ? $album['release_label'] : $album['release_type'];
        ?>
            <div class="album-card">
                <div class="album-info">
                    <img src="<?= htmlspecialchars($album_cover) ?>" alt="<?= htmlspecialchars($album['title']) ?> Cover" class="album-cover">
                    <h3 class="album-title"><?= htmlspecialchars($album['title']) ?></h3>
                    <p class="album-meta"><?= htmlspecialchars($meta_label) ?><?= $album_date ? ' • ' . $album_date : '' ?></p>
                    <p class="album-desc"><?= htmlspecialchars($album['description'] ?? '') ?></p>
                </div>

                <div class="tracklist">
                    <?php if ($q_tracks && mysqli_num_rows($q_tracks) > 0) : ?>
                        <?php $no = 1; while ($track = mysqli_fetch_assoc($q_tracks)) : 
                            $track_num   = !empty($track['track_number']) ? $track['track_number'] : $no;
                            $track_cover = resolveImagePath($track['cover_path'], $album_cover);
                            $track_date  = !empty($track['release_date']) ? date('M j, Y', strtotime($track['release_date'])) : $album_date;
                        ?>
                        <div class="track-item">
                            <div class="track-details-wrapper">
                                <img src="<?= htmlspecialchars($track_cover) ?>" alt="<?= htmlspecialchars($track['title']) ?> Cover" class="track-cover">
                                <div class="track-info">
                                    <span class="track-name"><?= htmlspecialchars($track_num) ?>. <?= htmlspecialchars($track['title']) ?></span>
                                    <span class="track-date">
                                        Released: <?= htmlspecialchars($track_date) ?>
                                        <?php if (!empty($track['play_count']) && $track['play_count'] > 0) : ?>
                                            • <?= number_format($track['play_count']) ?> plays
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="media-buttons">
                                <?php if (!empty($track['spotify_url'])) : ?>
                                    <a href="<?= htmlspecialchars($track['spotify_url']) ?>" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                                <?php endif; ?>
                                <?php if (!empty($track['youtube_url'])) : ?>
                                    <a href="<?= htmlspecialchars($track['youtube_url']) ?>" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $no++; endwhile; ?>
                    <?php else : ?>
                        <p style="color:#a1a1aa; text-align:center;">No tracks added for this album yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; endif; ?>

        <?php if (!$found_any) : ?>
            <p style="text-align:center; color:#0ff; font-size:1.15rem; padding: 30px;">No matching tracks or albums found.</p>
        <?php endif; ?>

    </section>

</body>
</html>