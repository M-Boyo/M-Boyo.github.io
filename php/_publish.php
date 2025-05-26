<?php
require_once '_header.php';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO message (UserId, Content, Date) VALUES (:user_id, :message, strftime('%s', 'now'))");
            $stmt->execute([
                ':user_id' => $user_id,
                ':message' => $message
            ]);
            header("Location: /");
            exit();
        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            header("Location: /message?error=1");
            exit();
        }
    } else {
        header("Location: /publish?error=2");
        exit();
    }
}

?>