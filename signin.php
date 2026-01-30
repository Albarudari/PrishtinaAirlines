<?php
require_once 'Database.php';
require_once 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
        if ($_SESSION['user_role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: homepage.php");
        }
        exit;
    } else {
        echo "Invalid email or password!";
    }
}
?>