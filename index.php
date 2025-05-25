<?php
// filepath: c:\Users\sailv\Desktop\Projet web\index.php
session_start();
setlocale(LC_ALL, 'fr_FR');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bienvenue sur Bizou !!">
    <title>Bizou</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/transition.css">
    <link rel="stylesheet" href="styles/music-player.css">
    <script src="scripts/main.js" defer></script>
    <script src="scripts/url-router.js" defer></script>

</head>

<body>
    <header class="header">
        <div class="header__background">
            <div class="header__title">
                <marquee class="header__marquee" behavior="alternate" direction="left" scrollamount="4">
                    💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗
                    🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷
                    💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷
                </marquee>
                <a href="/">
                    <h1 class="header__heading">BIZOU</h1>

                </a>
                <marquee class="header__marquee" behavior="alternate" direction="right" scrollamount="4">
                    💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗
                    🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷
                    💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷 💗 🩷
                </marquee>

            </div>
        </div>
        <nav class="navbar">
            <div id="music-player" class="navbar__music-player">
                <audio id="audio-control" controls="" controlslist="noplaybackrate nodownload"
                    src="audio/song.mp3"></audio>
                <div class="music-player__controls">
                    <button class="btn music-player__btn music-player__btn--prev">⏮</button>
                    <button class="btn music-player__btn music-player__btn--next">⏭</button>
                    <span class="music-player__current-song">Aucune chanson en cours</span>
                </div>
            </div>
            <div class="navbar__links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="btn navbar__btn" href="/profile">Mon profil</a>
                    
                <?php else: ?>
                    <a class="btn navbar__btn" href="/login">Connexion</a>
                    <a class="btn navbar__btn" href="/register">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <nav class="primary-nav">
            <ul class="primary-nav__list">
                <li class="primary-nav__item">
                    <a class="primary-nav__link" href="/">🏠 Accueil</a>
                </li>
                <li class="primary-nav__item">
                    <a class="primary-nav__link" href="/message">🌠 Publications</a>
                </li>

                <li class="primary-nav__item">
                    <a class="primary-nav__link" href="/contact">📧 Contact</a>
                </li>

                <li class="primary-nav__item">
                    <a class="primary-nav__link" href="/about">📖 À propos</a>
                </li> 



            </ul>
        </nav>
        <div id="content"></div>

    </main>
</body>

</html>