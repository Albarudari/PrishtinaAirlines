<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'M/ContactMapper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mapper = new ContactMapper();
        
        if ($mapper->insertInquiry($name, $email, $message)) {
            echo "<script>
                alert('Thank you for your message!');
                window.location.href = 'homepage.php';
            </script>";
            exit();
        } else {
            echo "GABIM: Metoda insertInquiry ktheu false. Kontrollo DB.";
        }
    } else {
        echo "GABIM: Fushat janë zbrazët.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Prishtina Airlines</title>
    <link rel="stylesheet" href="contactform.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<section class="contact-section">
    <div class="contact-container">
        <h2>Contact Us</h2>

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