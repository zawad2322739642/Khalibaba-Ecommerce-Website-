<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "khalibaba";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function taka($amount) {
    return "৳" . number_format((float)$amount, 2);
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /Khalibaba/auth/login.php");
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: /Khalibaba/index.php");
        exit;
    }
}
?>