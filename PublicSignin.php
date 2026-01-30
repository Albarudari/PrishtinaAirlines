<?php
session_start();
require_once "../config/Database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT id, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = strtolower(trim($user['role']));

        if ($_SESSION['role'] === 'admin') {
            header("Location: homepage.html");
            exit();
        } else {
            header("Location: dashboard.php");
            exit();
        }
    }

    header("Location: PublicSignin.php?error=1");
    exit();
}
?>
