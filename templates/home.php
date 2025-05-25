<?php
require_once '../php/_home.php';
$messages = getMessagesFromDatabase($pdo);
?>

<div class="homepage-section">
    <h1 class="homepage-section__title">💗 Bienvenue sur Bizou 💗</h1>
    <h2 class="homepage__subtitle">
        La maison de tout les zouzous
    </h2>
    <div class="homepage">
        <p class="homepage__description">
            Des bisous, des poutous, et même du fufu pour les plus foufou d'entre vous 🌸<br>
            🌈Que tu sois un grigou, un loulou ou un filou. Ca coûte walou de nous faire coucou !<br>
            Rejoignez Bizou, la communauté sans taboo des boutchou de Katmandou à Tombouctou ✨ <br>
        </p>
    </div>
    <div class="feed-section">
        <h2 class="feed-section__title">
            <span class="feed-section__icon">🩷</span>
            <span class="feed-section__text">Fil d'actualité</span>
        </h2>
        <div class="feed">
            <?php if (empty($messages)): ?>
                <p class="homepage__description">Y a personne... ≡(▔﹏▔)≡</p>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="feed-item">
                        <a href="/user/<?= $message['UserId'] ?>" class="feed-item__author"><?= displayAuthor($message['UserId'], $pdo) ?></a>
                        <div class="feed-item__date"><?= date('j F Y', ($message['Date'])) ?></div>
                        <div class="feed-item__content"><?= htmlspecialchars($message['Content']) ?></div>
                        <div class="feed-item__actions">
                            <form action="php/_like.php" method="post">
                                <input type="hidden" name="message_id" value="<?= htmlspecialchars($message['MessageId']) ?>">
                                <button class="feed-item__btn">
                                    <span class="feed-item__btn-icon">💗</span>
                                    <span class="feed-item__like-count"><?= getLikeCount($message['MessageId'], $pdo) ?></span>
                                </button>
                            </form>
                            <button class="feed-item__btn" type="submit">
                                <span class="feed-item__btn-icon">💬</span>
                                <span class="feed-item__btn-text">Commenter</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>