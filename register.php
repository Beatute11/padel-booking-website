<?php
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $vardas = $_POST['vardas'];
    $el_pastas = $_POST['el_pastas'];
    $slaptazodis = password_hash($_POST['slaptazodis'], PASSWORD_DEFAULT);

    // Patikrinu ar el pastas egzistuoja
    $tikrinti_pasta = $conn -> prepare("SELECT el_pastas FROM vartotojai WHERE el_pastas = ?");
    $tikrinti_pasta->bind_param("s", $el_pastas);
    $tikrinti_pasta->execute();
    $tikrinti_pasta->store_result();

    if ($tikrinti_pasta->num_rows > 0) {
        die("Vartotojas jau egzistuoja");
    }

    // Ideti vartotoja i DB
    $sql = "INSERT INTO vartotojai (vardas, el_pastas, slaptazodis)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $vardas, $el_pastas, $slaptazodis);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Klaida: " . $conn->error;
    }
}
