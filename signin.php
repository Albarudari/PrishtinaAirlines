<?php
session_start();
require_once 'Database.php';
require_once 'M/UserMapper.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
    $userMapper = new UserMapper();
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Marrim të dhënat e përdoruesit nga Database përmes Mapper-it
    $userData = $userMapper->getUserByEmail($email);

    // Verifikojmë nëse përdoruesi ekziston dhe nëse password-i i shkruar përputhet me hash-in në DB
    if ($userData && password_verify($password, $userData['password'])) {
        
        // Ruajmë të dhënat kyçe në Session
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['name']; // Përdorim kolonën 'name'
        $_SESSION['user_role'] = $userData['role'] ?? 'user';

        // RIDREJTIMI SIPAS ROLIT
        if (strtolower(trim($_SESSION['user_role'])) === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: homepage.php");
        }
        exit();
    } else {
        $error_message = "Email or Password incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prishtina Airlines</title>
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="signin-body">

<div class="signin-container">
    <h2>Sign In</h2>

    <?php if (!empty($error_message)): ?>
        <div class="error-msg"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form id="signinForm" method="POST" action="signin.php" novalidate>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <div class="error" id="emailError"></div>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fa-solid fa-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
            </div>
            <div class="error" id="passwordError"></div>
        </div>

        <button type="submit" class="signin-btn">Login</button>
    </form>

    <div class="signin-footer">
        <a href="homepage.php" class="back-link">← Back to Home</a>
        <p>Don't have an account? <a href="signup.php" class="create-link">Create account</a></p>
    </div>
</div>

<script src="signin.js"></script>
</body>
</html>