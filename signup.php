<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'Database.php';
require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $name        = $_POST['first_name'];
    $surname     = $_POST['last_name'];
    $dob         = $_POST['dob'];
    $nationality = $_POST['nationality'];
    $country     = $_POST['country'];
    $city        = $_POST['city'];
    $zip         = $_POST['zip'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $password    = $_POST['password'];

    if ($user->register($name, $surname, $dob, $nationality, $country, $city, $zip, $phone, $email, $password)) {
 
        header("refresh:2; url=signin.html");
        echo "<h2 style='text-align:center; font-family:sans-serif; margin-top:50px;'>Account created successfully! Please login to continue.</h2>";
    } else {
        echo "We couldn’t complete your registration. Please try again.";
    }
}
?>