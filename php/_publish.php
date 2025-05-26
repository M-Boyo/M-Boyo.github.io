<?php
require_once '_header.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $parent_message_id = isset($_POST['ParentMessageId']) ? $_POST['ParentMessageId'] : null;

    if (!empty($message)) {
        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO message (UserId, Content, Date, ParentMessageId) VALUES (:user_id, :message, strftime('%s', 'now'), :parent_message_id)";
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':message', $message, PDO::PARAM_STR);  // No htmlspecialchars here!

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
        } catch (PDOException $e) {
            // Log the error
            error_log("Database insert failed: " . $e->getMessage());

            // Redirect to error page
            header("Location: /publish?error=1");
            exit();
        }
    } else {
        // Redirect to error page
        header("Location: /publish?error=2");
        exit();
    }
}

?>