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