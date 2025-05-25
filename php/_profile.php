<?php
require_once '_header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: /login"); // Redirect to login if not authenticated 
    exit;
}
$userId = $_SESSION['user_id'];
$user = fetchDatabase($pdo, "SELECT Email, InscriptionDate FROM bizou_user WHERE Id = :userId", [':userId' => $userId]);
$user = $user[0]; 
$email = htmlspecialchars($user['Email']);  
$InscriptionDate = htmlspecialchars($user['InscriptionDate']); 

?>