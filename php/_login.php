<?php
// filepath: c:\Users\sailv\Desktop\Projet web\php\login.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

session_start(); // Start the session

$db_path = __DIR__ . '/../bizou.sqlite3'; // Path to your database
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
    $password = $_POST["password"];

    // 1. Retrieve User from Database
    try {
        $stmt = $pdo->prepare("SELECT * FROM bizou_user WHERE Name = :name");
        $stmt->execute([':name' => $name]);
        $user = $stmt->fetch();

        if ($user) {
            // 2. Verify Password
            if (password_verify($password, $user["PasswordHash"])) {
                // 3. Authentication Successful
                $_SESSION["user_id"] = $user["Id"]; // Store user ID in session
                $_SESSION["username"] = $user["Name"]; // Store username in session

                http_response_code(200);
                echo json_encode(["message" => "Login successful!", "username" => $user["Name"]]);
                // Optionally, you can redirect or return a token for further use
                header("Location: /profile"); // Redirect to profile page
                exit;
            } else {
                // Invalid password
                http_response_code(401); // Unauthorized
                echo json_encode(["message" => "Invalid username or password."]);
                exit;
            }
        } else {
            // User not found
            http_response_code(401); // Unauthorized
            echo json_encode(["message" => "Invalid username or password."]);
            exit;
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Login failed: " . $e->getMessage()]);
        exit;
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed."]);
}
?>