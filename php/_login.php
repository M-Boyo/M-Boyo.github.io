<?php

require_once '_header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM bizou_user WHERE Name = :name");
    $stmt->execute([':name' => $name]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user["PasswordHash"])) {
    
            $_SESSION["user_id"] = $user["Id"];
            $_SESSION["username"] = $user["Name"];

            header("Location: /profile");
            exit;
        }
    }
    exit("Nom d'utilisateur ou mot de passe incorrect.");
} else {
    exit("Méthode de requête non autorisée.");
}
