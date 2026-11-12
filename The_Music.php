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
            margin-bottom: 60px;
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
            <a href="the_music.php" class="active">The Music</a>
        </div>
    </nav>

    <section id="the-music">
        <div class="section-header">
            <h2>The Music</h2>
            <p>Explore the complete discography of CORTIS.</p>
        </div>

        <!-- EP 1: Color Outside the Lines -->
        <div class="album-card">
            <div class="album-info">
                <img src="Assets/images/Color Outside the Lines.png" alt="Color Outside the Lines Cover" class="album-cover">
                <h3 class="album-title">Color Outside the Lines</h3>
                <p class="album-meta">1st EP • Sep 8, 2025</p>
                <p class="album-desc">A statement on self-discovery, embracing imperfections, and rejecting conventional societal rules and standards.</p>
            </div>
            <div class="tracklist">
                <!-- 1. GO! -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/GO!.png" alt="GO! Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">1. GO!</span>
                            <span class="track-date">Released: Aug 11, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/6OWWZtNQORY1McaZmOrwhc" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=WXS-o57VJ5w" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 2. What You Want -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/What You Want.png" alt="What You Want Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">2. What You Want</span>
                            <span class="track-date">Released: Aug 18, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/3rAcN3CLeSrkhIZN8PHbwb" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=e2OpbOv_JiQ" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 3. FaSHioN -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/FaSHioN.png" alt="FaSHioN Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">3. FaSHioN</span>
                            <span class="track-date">Released: Sep 8, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/4ecdsGz3Hg6TKPwQ0ZOdJz" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=42wfEs7oIP8" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 4. JoyRide -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/JoyRide.png" alt="JoyRide Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">4. JoyRide</span>
                            <span class="track-date">Released: Sep 8, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/6T17ZI0glfM2IGLdUwtnLK" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=8QZeXvOjgGE" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 5. Lullaby -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/Lullaby.png" alt="Lullaby Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">5. Lullaby</span>
                            <span class="track-date">Released: Sep 8, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/0nyhsAcyDj533QrXa4hUug" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=8ej2YOBsimQ" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 6. What You Want (feat. Teezo Touchdown) -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/What You Want (feat. Teezo Touchdown).png" alt="What You Want Remix Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">6. What You Want (feat. Teezo Touchdown)</span>
                            <span class="track-date">Released: Aug 22, 2025</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/1pFQRreMptp3dkh64WiUNx" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=J8s5-vsT_Dc" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- EP 2: GreenGreen -->
        <div class="album-card">
            <div class="album-info">
                <img src="Assets/images/GreenGreen.png" alt="GreenGreen Cover" class="album-cover">
                <h3 class="album-title">GreenGreen</h3>
                <p class="album-meta">2nd EP • May 4, 2026</p>
                <p class="album-desc">Represents CORTIS's mature principles, dividing priorities into "Green" (pursuits) and "Red" (red flags/social pressures to reject).</p>
            </div>
            <div class="tracklist">
                <!-- 1. TNT -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/TNT.png" alt="TNT Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">1. TNT</span>
                            <span class="track-date">Released: May 4, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/7diH1qnFziArYzynk3vkr6" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=kRpaqR5sbf0" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 2. RedRed -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/RedRed.png" alt="RedRed Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">2. RedRed</span>
                            <span class="track-date">Released: Apr 20, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/2fCwv2ppU5nTRTckomIGsd" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=U6BDbXIah-Y" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 3. Acai -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/Acai.png" alt="Acai Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">3. Acai</span>
                            <span class="track-date">Released: May 4, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/7Ldcvhcl4Xj4eOTSWpZus5" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=nCElUD0jvgo" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 4. YoungCreatorCrew -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/YoungCreatorCrew.png" alt="YoungCreatorCrew Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">4. YoungCreatorCrew</span>
                            <span class="track-date">Released: May 4, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/2vKNzC9T3kdU2JECcvob3V" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=tCSBgOIA63M" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 5. Wassup -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/Wassup.png" alt="Wassup Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">5. Wassup</span>
                            <span class="track-date">Released: May 4, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/3dCdcURa0Kk5UWXRY00HQy" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=oEow4l7mP7c" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>

                <!-- 6. Blue Lips -->
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/Blue Lips.png" alt="Blue Lips Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">6. Blue Lips</span>
                            <span class="track-date">Released: May 4, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/1VyXprVXZYNGWWZf1u4JfN" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=hOIY3OhvD94" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SINGLE 1: Mention Me -->
        <div class="album-card">
            <div class="album-info">
                <img src="Assets/images/Mention Me.png" alt="Mention Me Cover" class="album-cover">
                <h3 class="album-title">Mention Me</h3>
                <p class="album-meta">Digital Single • Feb 13, 2026</p>
                <p class="album-desc">Released as the Official Soundtrack (OST) for the American animated sports comedy film "GOAT".</p>
            </div>
            <div class="tracklist">
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/Mention Me (2).png" alt="Mention Me Track Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">1. Mention Me</span>
                            <span class="track-date">Released: Feb 13, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/track/3f0OEJd7mlPNhmH3fUOrqy" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=iGGxMGeJzmw" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SINGLE 2: It's Me X Redred -->
        <div class="album-card">
            <div class="album-info">
                <img src="Assets/images/It's Me X Redred.png" alt="It's Me X Redred Cover" class="album-cover">
                <h3 class="album-title">It's Me X Redred</h3>
                <p class="album-meta">Digital Single • Jun 5, 2026</p>
                <p class="album-desc">An exclusive digital mashup track distributed on YouTube, combining the beats of CORTIS's "RedRed" with "It's Me".</p>
            </div>
            <div class="tracklist">
                <div class="track-item">
                    <div class="track-details-wrapper">
                        <img src="Assets/images/It's Me X Redred (2).png" alt="It's Me X Redred Track Cover" class="track-cover">
                        <div class="track-info">
                            <span class="track-name">1. It's Me X Redred</span>
                            <span class="track-date">Released: Jun 5, 2026</span>
                        </div>
                    </div>
                    <div class="media-buttons">
                        <a href="https://open.spotify.com/playlist/1u6HN7g47i4sCELDWgemWp" target="_blank" class="btn btn-spotify">Play Music on Spotify</a>
                        <a href="https://www.youtube.com/watch?v=XAZWDEljjdk" target="_blank" class="btn btn-youtube">Play MV on Youtube</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</body>
</html>