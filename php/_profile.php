<?php
require_once '_header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: /login"); 
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM bizou_user WHERE Id = :userId");
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$email = htmlspecialchars($user['Email']);  
$InscriptionDate = htmlspecialchars($user['InscriptionDate']);

$stmt = $pdo->prepare("SELECT Content, Date FROM message WHERE UserId = :userId ORDER BY Date DESC");
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll();

?>