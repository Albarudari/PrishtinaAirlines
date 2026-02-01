<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'M/ContactMapper.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $mapper = new ContactMapper();
            
            if ($mapper->insertInquiry($name, $email, $message)) {
                echo "<script>
                    alert('Thank you for your message, $name!');
                    window.location.href = 'homepage.php';
                </script>";
                exit();
            } else {
                $error_message = "Database error: Nuk u arrit të ruhej mesazhi.";
            }
        } catch (Exception $e) {
            $error_message = "Fatal error: " . $e->getMessage();
        }
    } else {
        $error_message = "Ju lutem plotësoni të gjitha fushat (Emrin, Email-in dhe Mesazhin).";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Prishtina Airlines</title>
    <link rel="stylesheet" href="contactform.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .error-box {
            background: #ffdbdb;
            color: #a30000;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

<section class="contact-section">
    <div class="contact-container">
        <h2>Contact Us</h2>

        <?php if (!empty($error_message)): ?>
            <div class="error-box"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="contact-form">
            
            <div class="input-group">
                <input type="text" name="name" placeholder="Your name" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Your email" required>
            </div>

            <div class="input-group">
                <textarea name="message" placeholder="Write your message here..." rows="3" required></textarea>
            </div>

            <button type="submit" name="submit_contact">Send</button>
        </form>
    </div>
</section>

</body>
</html>