<?php
require_once '_header.php';

// Function to fetch messages from the database
function getMessagesFromDatabase($pdo)
{
    $stmt = $pdo->query("SELECT * FROM message ORDER BY Date DESC");
    return $stmt->fetchAll();
}

// filepath: c:\Users\sailv\Desktop\Projet web\php\_header.php
function displayAuthor($author, $pdo)
{
    if (empty($author)) {
        return "Anonyme";
    }

    $authorName = "";
    if (is_numeric($author)) {
        // Assuming $author is a user ID, fetch the username from the database
        try {
            $stmt = $pdo->prepare("SELECT Name FROM bizou_user WHERE Id = :userId");
            $stmt->bindParam(':userId', $author, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $authorName = htmlspecialchars($result['Name']);
            } else {
                $authorName = "Anonyme";
            }
        } catch (PDOException $e) {
            error_log("Error fetching author: " . $e->getMessage());
            return "Anonyme";
        }
    } else {
        // If it's not a numeric ID, treat it as a username
        $authorName = htmlspecialchars($author);
    }

    return $authorName;
}

function getLikeCount($messageId, $pdo)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM message_like WHERE MessageId = :messageId");
    $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

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
            <div class="feed-item__actions">
                <form action="php/_like.php" method="post">
                    <input type="hidden" name="message_id" value="<?= htmlspecialchars($comment['MessageId']) ?>">
                    <button class="feed-item__btn">
                        <span class="feed-item__btn-icon">💗</span>
                        <span class="feed-item__like-count"><?= getLikeCount($comment['MessageId'], $pdo) ?></span>
                    </button>
                </form>
                <a href="/publish?reply_to=<?= htmlspecialchars($comment['MessageId']) ?>" class="feed-item__btn">
                    <span class="feed-item__btn-icon">💬</span>
                    <span class="feed-item__btn-text">Répondre</span>
                </a>
            </div>

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
