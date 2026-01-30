<?php
$conn = new mysqli("localhost", "root", "", "prishtinaairlines");

if ($conn->connect_error) {
    die("Nuk u lidha ❌ " . $conn->connect_error);
}

echo "Lidhja me databazën PRISHTINAAIRLINES OK ✅";
?>
