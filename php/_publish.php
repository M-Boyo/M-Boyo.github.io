<?php
require_once '_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $parent_message_id = isset($_POST['ParentMessageId']) ? $_POST['ParentMessageId'] : null;

    if (!empty($message)) {

        $sql = "INSERT INTO message (UserId, Content, Date, ParentMessageId) VALUES (:user_id, :message, strftime('%s', 'now'), :parent_message_id)";
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);

        if ($parent_message_id === null || $parent_message_id === '0') {
            $stmt->bindValue(':parent_message_id', null, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':parent_message_id', $parent_message_id, PDO::PARAM_INT);
        }

        // Execute the statement
        $stmt->execute();

        // Redirect to home page
        header("Location: /");
        exit();
    } else {
       exit("Le message ne peut pas être vide.");
    }

}

exit("Méthode de requête non autorisée.");
