<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = $user->login($email, $password);

    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_role'] = $userData['role'];

        $role = strtolower(trim($userData['role']));

        if ($role === 'admin') {
            header("Location: homepage.php");
        } else {
            header("Location: homepage.php");
        }
        exit();
    } else {
        header("refresh:2; url=signin.php"); 
        echo "<h2 style='text-align:center; font-family:sans-serif; margin-top:50px; color:red;'>
                Email or Password incorrect!
              </h2>";
    }
}
?>