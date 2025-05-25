<?php
// filepath: c:\Users\sailv\Desktop\Projet web\php\register.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$db_path = __DIR__ . '/../bizou.sqlite3'; // Or '/dbizou.sqlite3'
try {
    $pdo = new PDO("sqlite:" . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = isset($_POST["email"]) ? $_POST["email"] : null; // Email is optional
    $password = $_POST["password"];

    // Basic validation (improve this!)
    if (empty($name) || empty($password)) {
        http_response_code(400);
        echo json_encode(["message" => "Name and password are required."]);
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO bizou_user (Name, Picture, InscriptionDate, PasswordHash, Email) VALUES (:name, :picture, strftime('%s', 'now'), :password_hash, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":picture" => 'profilePictures/default.webp',
            ":password_hash" => $password_hash,
            ":email" => $email
        ]);

        http_response_code(201); // Created
        echo json_encode(["message" => "User registered successfully!"]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Registration failed: " . $e->getMessage()]);
    }

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed."]);
}
?>