<?php
// Header for the PHP application
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
session_start(); // Start the session

// Set locale for date formatting
setlocale(LC_ALL, 'fr_FR.UTF-8');
// Define the path to the database
$db_path = __DIR__ . '/../bizou.sqlite3'; // Path to your database
// Create a new PDO instance for database connection

$pdo = new PDO("sqlite:" . $db_path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
