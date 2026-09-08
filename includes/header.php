<?php require_once __DIR__ . "/config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? e($pageTitle) . " | " : "" ?>Khalibaba</title>
<link rel="stylesheet" href="/Khalibaba/assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="/Khalibaba/index.php"><img src="/Khalibaba/assets/images/khalibaba-logo.jpeg" alt="Khalibaba logo"> <span>Khalibaba</span></a>
  <nav>
    <a href="/Khalibaba/index.php">Shop</a>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'buyer'): ?>
      <a href="/Khalibaba/buyer/cart.php">Cart</a>
      <a href="/Khalibaba/buyer/dashboard.php">Dashboard</a>
      <a href="/Khalibaba/buyer/support.php">Support</a>
    <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'seller'): ?>
      <a href="/Khalibaba/seller/dashboard.php">Seller Dashboard</a>
    <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
      <a href="/Khalibaba/admin/dashboard.php">Admin Dashboard</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['user'])): ?>
      <a class="btn small" href="/Khalibaba/auth/logout.php">Logout</a>
    <?php else: ?>
      <a href="/Khalibaba/auth/login.php">Login</a>
      <a class="btn small" href="/Khalibaba/auth/register.php">Register</a>
      <a class="btn small secondary" href="/Khalibaba/admin/login.php">Admin login</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
