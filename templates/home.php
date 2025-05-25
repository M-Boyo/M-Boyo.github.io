<?php
require_once '../php/_home.php';
$db_path = __DIR__ . '/../bizou.sqlite3';
try {
    $pdo = new PDO("sqlite:" . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
$messages = getMessagesFromDatabase($pdo);
echo "<!-- Messages fetched successfully " . (is_array($messages) ? count($messages) : 0) . " messages found -->";

?>

<div class="homepage-section">
    <h1 class="homepage-section__title">💗 Bienvenue sur Bizou 💗</h1>
    <h2 class="homepage__subtitle">
        La maison de tout les zouzous
    </h2>
    <div class="homepage">
        <p class="homepage__description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum quisquam tempora
            error possimus fuga minus porro
            obcaecati a nostrum, quos rerum quas? Eius tenetur molestiae fugit dolorem ab illo beatae necessitatibus
            numquam, facilis ratione incidunt aut ipsa illum odio voluptate consectetur in distinctio perferendis
            voluptatum. Reprehenderit autem non iure officiis eos eveniet laboriosam quia? Quisquam quo dolores aliquam
            labore nemo sit aperiam cum velit nostrum veniam. Omnis quibusdam illum, fuga saepe earum porro ex ut ipsam
            aliquid perspiciatis. Optio minus repellendus eos odio omnis. Possimus ad, odit, atque repudiandae vel dicta
            id,
            quia laboriosam perspiciatis distinctio ab. Deserunt, aut nam.
        </p>
    </div>
    <div class="feed-section">
        <h2 class="feed-section__title">
            <span class="feed-section__icon">🩷</span>
            <span class="feed-section__text">Fil d'actualité</span>
        </h2>
        <div class="feed">
            <?php if (empty($messages)): ?>
                <p>Y a personne ≡(▔﹏▔)≡</p>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="feed-item">
                        <a href="#" class="feed-item__author"><?= displayAuthor($message['UserId']) ?></a>
                        <div class="feed-item__date"><?= date('j F Y', ($message['Date'])) ?></div>
                        <div class="feed-item__content"><?= htmlspecialchars($message['Content']) ?></div>
                        <div class="feed-item__actions">
                            <button class="feed-item__btn">
                                <span class="feed-item__btn-icon">💗</span>
                                <span class="feed-item__like-count"><?= htmlspecialchars($message['LikeCount']) ?></span>
                            </button>
                            <button class="feed-item__btn">
                                <span class="feed-item__btn-icon">💬</span>
                                <span class="feed-item__btn-text">Commenter</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- <div class="feed">
            <div class="feed-item">
                <a href="" class="feed-item__author">Alice</a>
                <div class="feed-item__date">24 mai 2025</div>
                <div class="feed-item__content">
                    J'adore me promener en forêt au printemps 🌳🌸
                </div>
                <div class="feed-item__actions">
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💗</span>
                        <span class="feed-item__like-count">12</span>
                    </button>
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💬</span>
                        <span class="feed-item__btn-text">Commenter</span>
                    </button>
                </div>
            </div>
            <div class="feed-item">
                <a class="feed-item__author">Bob</a>
                <div class="feed-item__date">22 mai 2025</div>
                <div class="feed-item__content">
                    Quelqu'un pour une randonnée ce week-end ? 🚶‍♂️🌲
                </div>
                <div class="feed-item__actions">
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💖</span>
                        <span class="feed-item__like-count">12</span>
                    </button>
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💬</span>
                        <span class="feed-item__btn-text">Commenter</span>
                    </button>
                </div>
            </div>
            <div class="feed-item">
                <a class="feed-item__author">Chloé</a>
                <div class="feed-item__date">21 mai 2025</div>
                <div class="feed-item__content">
                    Les couchers de soleil au bord du lac sont magiques en ce moment ! 🌅💗
                </div>
                <div class="feed-item__actions">
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💖</span>
                        <span class="feed-item__like-count">12</span>
                    </button>
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💬</span>
                        <span class="feed-item__btn-text">Commenter</span>
                    </button>
                </div>
            </div>
        </div> -->
    </div>
</div>