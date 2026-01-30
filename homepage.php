<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: PublicSignin.php");
    exit;
}

echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!</h1>";
echo "<p><a href='signout.php'>Sign Out</a></p>";

