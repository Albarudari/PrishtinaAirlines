<?php
session_start();
require_once 'Database.php';
require_once 'M/UserMapper.php';

$message = "";
$message_type = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userMapper = new UserMapper();

    $name        = $_POST['first_name'] ?? '';
    $surname     = $_POST['last_name'] ?? '';
    $birthdate   = $_POST['dob'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $country     = $_POST['country'] ?? '';
    $city        = $_POST['city'] ?? '';
    $zip_code    = $_POST['zip'] ?? '';
    $phone       = $_POST['phone'] ?? '';
    $email       = $_POST['email'] ?? '';
    $password    = $_POST['password'] ?? '';
    $confirm_pw  = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_pw) {
        $message = "Passwords do not match!";
        $message_type = "error";
    } else if ($userMapper->getUserByEmail($email)) {
        $message = "This email is already registered!";
        $message_type = "error";
    } else {
        if ($userMapper->register($name, $surname, $birthdate, $nationality, $country, $city, $zip_code, $phone, $email, $password)) {
            $message = "Account created successfully! Redirecting to login...";
            $message_type = "success";
            header("refresh:2; url=signin.php");
        } else {
            $message = "Something went wrong. Please try again.";
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Prishtina Airlines</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .status-msg {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }
        .msg-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .msg-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body class="signup-body">

<div class="signup-container">
    <h2>Create Account</h2>

    <?php if (!empty($message)): ?>
        <div class="status-msg <?php echo ($message_type == 'success') ? 'msg-success' : 'msg-error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form id="signupForm" action="signup.php" method="POST" novalidate>
        <div class="row">
            <div class="field">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="field">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="last_name" placeholder="Enter last name" required>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="field">
                <label for="nationality">Nationality</label>
                <select id="nationality" name="nationality">
                    <option value="Select">Select</option>
                    <option value="Albanian">Albanian</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="country">Country</label>
                <select id="country" name="country">
                    <option value="Select">Select</option>
                    <option value="Kosovo">Kosovo</option>
                    <option value="Germany">Germany</option>
                </select>
            </div>
            <div class="field">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Enter city">
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="zip">ZIP Code</label>
                <input type="text" id="zip" name="zip" placeholder="Enter ZIP code">
            </div>
            <div class="field">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="+383 44 000 000">
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                    <i class="fa-solid fa-eye-slash toggle-icon" id="togglePassword"></i>
                </div>
            </div>

            <div class="field">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Retype password" required>
                    <i class="fa-solid fa-eye-slash toggle-icon" id="toggleConfirmPassword"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="signup-btn">Create Account</button>

        <a class="back" href="homepage.php">← Back to Home</a>
        <p class="signin-text">
            Already have an account? <a href="signin.php">Sign In</a>
        </p>
    </form>
</div>

<script src="signup.js"></script>
</body>
</html>