<?php
function getMessagesFromDatabase($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM message ORDER BY Date DESC"); // Corrected table name
        $stmt->execute();
        $messages = $stmt->fetchAll();
        return $messages;
    } catch (PDOException $e) {
        error_log("Error fetching messages: " . $e->getMessage());
        return [];
    }
}

function displayAuthor($author) {
    if (empty($author)) {
        return "Anonyme";
    }

    $authorName = "";
    if (is_numeric($author)) {
        // Assuming $author is a user ID, fetch the username from the database
        global $pdo; // Use the global PDO instance
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

    // Return the sanitized author name

    return $authorName;
}
?>