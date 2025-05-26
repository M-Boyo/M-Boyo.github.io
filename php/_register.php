<?php
require_once '_header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = $_POST["password"];


    if (empty($name) || empty($password)) {
        http_response_code(400);
        echo json_encode(["message" => "Name and password are required."]);
        exit;
    }


    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO bizou_user (Name, Picture, InscriptionDate, PasswordHash, Email) VALUES (:name, :picture, strftime('%s', 'now'), :password_hash, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":name" => $name,
        ":picture" => 'profilePictures/default.webp',
        ":password_hash" => $password_hash,
        ":email" => $email
    ]);

    echo json_encode(["message" => "User registered successfully!"]);
    header("Location: /login");
} else {
    exit("Method not allowed.");
}
