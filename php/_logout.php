<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

session_start(); 
$_SESSION = [];

session_destroy();


echo json_encode(["message" => "Logout successful."]);
header("Location: /");
exit;

