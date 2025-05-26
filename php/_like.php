<?php
require_once '_header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

// Check if there is a message ID
if (!isset($_POST['message_id']) || !is_numeric($_POST['message_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid message ID']);
    exit();
}

$message_id = (int)$_POST['message_id'];
$user_id = $_SESSION['user_id'];

// Check if the message exists in the database
$stmt = $pdo->prepare("SELECT * FROM message WHERE MessageId = :message_id");                    
$stmt->execute([':message_id' => $message_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$message) {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Message not found']);
    exit();
}

// Check if the user has already liked this message
$stmt = $pdo->prepare("SELECT * FROM message_like WHERE UserId = :user_id AND MessageId = :message_id");
$stmt->execute([':user_id' => $user_id, ':message_id' => $message_id]);
$like = $stmt->fetch(PDO::FETCH_ASSOC);
if ($like) {
    // User has already liked this message, so we remove the like
    $stmt = $pdo->prepare("DELETE FROM message_like WHERE UserId = :user_id AND MessageId = :message_id");
    $stmt->execute([':user_id' => $user_id, ':message_id' => $message_id]);
} else {
    // User has not liked this message, so we add a like
    $stmt = $pdo->prepare("INSERT INTO message_like (UserId, MessageId) VALUES (:user_id, :message_id)");
    $stmt->execute([':user_id' => $user_id, ':message_id' => $message_id]);
}
echo $message_id;
header("location: /");