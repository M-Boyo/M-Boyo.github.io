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
                <?php foreach ($messages as $message): if ($message['ParentMessageId']) continue?>
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
                            <a href="/message?reply_to=<?= htmlspecialchars($message['MessageId']) ?>" class="feed-item__btn">
                                <span class="feed-item__btn-icon">💬</span>
                                <span class="feed-item__btn-text">Répondre</span>
                            </a>
                        </div>
                        <?php
                        // Fetch comments for this message
                        $comments = getCommentsForMessage($message['MessageId'], $pdo);
                        if (!empty($comments)): ?>
                            <div class="comments">
                                <?php displayComments($comments, $pdo, 0); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
function userLikedMessage($messageId, $userId, $pdo)
{
    if (!$userId) return false; // User not logged in

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM message_like WHERE UserId = :userId AND MessageId = :messageId");
    $stmt->execute([':userId' => $userId, ':messageId' => $messageId]);
    $likeCount = $stmt->fetchColumn();

    return $likeCount > 0;
}

function getCommentsForMessage($messageId, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM message WHERE ParentMessageId = :messageId ORDER BY Date ASC");
    $stmt->execute([':messageId' => $messageId]);
    return $stmt->fetchAll();
}

function displayComments($comments, $pdo, $depth)
{
    foreach ($comments as $comment):
        $depthClass = ($depth % 2 == 0) ? 'comment--even-depth' : 'comment--odd-depth';
        ?>
        <div class="comment feed-item <?= $depthClass ?>">
            <a href="/user/<?= htmlspecialchars($comment['UserId']) ?>" class="comment__author feed-item__author"><?= displayAuthor($comment['UserId'], $pdo) ?></a>
            <div class="comment__date feed-item__date"><?= date('j F Y', ($comment['Date'])) ?></div>
            <div class="comment__content feed-item__content"><?= htmlspecialchars($comment['Content']) ?></div>
            <?php
            $nestedComments = getCommentsForMessage($comment['MessageId'], $pdo);
            if (!empty($nestedComments)): ?>
                <div class="comments ">
                    <?php displayComments($nestedComments, $pdo, $depth + 1); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach;
}
?>