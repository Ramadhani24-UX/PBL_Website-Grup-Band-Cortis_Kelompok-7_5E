<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTIS: The Ultimate Guide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Memuat Font Syne dan Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Menghubungkan ke file CSS eksternal -->
    <link rel="stylesheet" href="Assets/css/Home_Page.css">
</head>

<body>
    
    <!-- POSTER BANNER -->
    <div class="top-poster-banner">
        <img src="Assets/images/CORTIS_POSTER.jpg" alt="CORTIS Poster Black and White">
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
                    <li><a href="the_music.php">#Stream Cortis</a></li>
                    <li><a href="Store.php">Support</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div id="home-page" class="page-content active">
            
            <div class="hero-container">
                <div class="hero-text-side">
                    <h1 class="hero-title">Hello COER!</h1>
                    <p class="hero-desc sub-hero">Cortis : Color Outside The Line </p>
                    <p class="hero-desc">An artist cherished for their music, performances, wit, and genuine friendships. What began as a small space to share guides and information has grown into something so much more.</p>
                    <p class="hero-desc">From a simple resource site to a full-fledged community hub – welcome to CORTIS : The Ultimate Guide.</p>
                    <p class="hero-desc">It's always been for CORTIS, for COERs, and for anyone discovering them today.🍀</p>
                    
                    <div class="cta-buttons">
                        <a href="About.php" class="btn-tosca-main">Baby Coer? Start here!</a>
                        <a href="the_music.php" class="btn-dark-main">#STREAM CORTIS</a>
                        <a href="Store.php" class="btn-border-dark">Support Today</a>
                    </div>
                </div>
                
                <div class="hero-image-side">
                    <img src="Assets/images/CORTIS.jpeg" alt="CORTIS Group Photo">
                </div>
            </div>

            <!-- BAGIAN GALERI -->
            <section id="members" style="margin-top: 40px; margin-bottom: 20px;">
                <div class="grid-3">
                    <div class="member-wrapper">
                        <img src="Assets/images/CORTIS_1.GIF" alt="Cortis Members" class="member-img-box">
                        <a href="About.php" class="member-btn btn-tosca-main">Baby Coer</a>
                    </div>
                    <div class="member-wrapper">
                        <img src="Assets/images/CORTIS_2.GIF" alt="Cortis Photo 2" class="member-img-box">
                        <a href="the_music.php" class="member-btn btn-dark-main">The Music</a>
                    </div>
                    <div class="member-wrapper">
                        <img src="Assets/images/CORTIS_3.GIF" alt="Cortis Photo 3" class="member-img-box">
                        <a href="Store.php" class="member-btn btn-border-dark">Store</a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Kotak Audio Player -->
        <div class="spotify-header">
            <h2 class="section-title">Listen to CORTIS </h2>
            <h2>Check out our latest and most popular tracks directly on Spotify</h2>
        </div>

        <div class="spotify-player-container">
            <iframe class="spotify-frame"
                src="https://open.spotify.com/embed/track/4ecdsGz3Hg6TKPwQ0ZOdJz?utm_source=generator&si=a2bfa6203b5c4a35"  
                frameBorder="0">
            </iframe>

            <iframe class="spotify-frame"
                src="https://open.spotify.com/embed/track/2fCwv2ppU5nTRTckomIGsd?utm_source=generator&si=def6346139ce47e2"  
                frameBorder="0">
            </iframe>
        </div>
    </div> 

    <div class="cookie-banner" id="cookieBanner">
        We use cookies. This website uses cookies to ensure you get the best experience.
        <button onclick="closeCookie()">Accept all</button> 
        <button onclick="closeCookie()">Reject all</button>
    </div>

    <footer>
        <p><em>Built with love by Fans, for Fans — always united for CORTIS.</em></p>
        <p>© 2026 Just Cortis | Unofficial fan-made website.</p>
    </footer>

    <script>
        const navLinks = document.querySelectorAll('.nav-link[data-target]');
        const pages = document.querySelectorAll('.page-content');
        const headerNavLinks = document.querySelectorAll('nav ul li a');

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetPageId = this.getAttribute('data-target');
                
                if (targetPageId) {
                    e.preventDefault();
                    
                    headerNavLinks.forEach(item => {
                        if(item.getAttribute('data-target') === targetPageId) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });

                    pages.forEach(page => page.classList.remove('active'));
                    const targetPage = document.getElementById(targetPageId);
                    if(targetPage) {
                        targetPage.classList.add('active');
                    }
                    
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        });

        function closeCookie() {
            document.getElementById('cookieBanner').style.display = 'none';
        }
    </script>
</body>

</html>