<?php
session_start();
session_unset();
session_destroy();

// Ndrysho 'signin.php' me emrin e saktë të fajllit tënd të login-it
header("Location: signin.html"); 
exit();
?>