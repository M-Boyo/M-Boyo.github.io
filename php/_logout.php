<?php
// Logout script
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

session_start(); // Start the session
// Unset all session variables
$_SESSION = [];
// Destroy the session
session_destroy();
// Return a success response
http_response_code(200);
echo json_encode(["message" => "Logout successful."]);
// Optionally, you can redirect to the home page or login page
header("Location: /");
exit;
// }
