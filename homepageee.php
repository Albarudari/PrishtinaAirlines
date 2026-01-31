<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prishtina Airlines</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body class="homepage-body">

<nav class="navbar">
    <div class="logo">✈ Prishtina Airlines</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="flights.html">Flights</a></li>
        <li><a href="hotels.html">Hotels</a></li>
        <li><a href="#about">Contact</a></li>
        
        <li class="user-info">
            <span style="color: white; font-weight: bold; margin-right: 10px;">
                Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
            </span>
            <a class="signin-btn" href="signout.php" style="background-color: #e74c3c;">Sign Out</a>
        </li>
    </ul>
</nav>

  <section class="hero">
    <div class="hero-content">
      <h1>Fly the Future, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
      <p>Your journey begins with us.</p>
      <a href="#" class="hero-btn">Book a Flight</a>
    </div>
  </section>