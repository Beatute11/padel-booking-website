<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $rezervacijos_id = $_POST['rezervacijos_id'];
    $vartotojo_id = $_SESSION['vartotojo_id'];

    $stmt = $conn->prepare("
        DELETE FROM rezervacijos
        WHERE id = ? AND vartotojo_id = ?
    ");
    $stmt->bind_param("ii", $rezervacijos_id, $vartotojo_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: my_reservations.php");
exit;
