<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

$vartotojo_id = $_SESSION['vartotojo_id'];
$aiksteles_id = $_POST['aiksteles_id'];
$data = $_POST['data'];
$laikas = $_POST['laikas'];

// Patikrinti ar laikas neužimtas
$check = $conn->prepare(
    "SELECT id FROM rezervacijos
     WHERE aiksteles_id = ? AND data = ? AND laikas = ?"
);
$check->bind_param("iss", $aiksteles_id, $data, $laikas);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Šis laikas jau užimtas!");
}

// Įrašyti rezervaciją
$stmt = $conn->prepare(
    "INSERT INTO rezervacijos (vartotojo_id, aiksteles_id, data, laikas)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("iiss", $vartotojo_id, $aiksteles_id, $data, $laikas);

if ($stmt->execute()) {
    echo "Rezervacija sėkminga!";
    echo '<br><a href="index.php">Grįžti</a>';
} else {
    echo "Klaida: " . $conn->error;
}
