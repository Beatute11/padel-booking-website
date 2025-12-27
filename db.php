<?php
$host = "localhost";
$vartotojas = "root";
$slaptazodis = "";
$db   = "auth_system";

// Prijungiu
$conn = new mysqli($host, $vartotojas, $slaptazodis, $db);

// Tikrinu ar pavyko prisijungti prie db
if ($conn -> connect_error) {
    die("Nepavyko prisijungti prie DB: " . $conn -> connect_error);
}
?>