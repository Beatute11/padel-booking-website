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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/connection.css">
    <title>Registracija</title>
</head>
<body>
    <div class="container">
        <div class="login_form">
            <h2>Registracija</h2>
            <form action="register.php" method="POST">
                <input type="text" name="vardas" placeholder="Vardas" required><br>
                <input type="email" name="el_pastas" placeholder="El. Pastas" required><br>
                <input type="password" name="slaptazodis" placeholder="Slaptas" required><br>
                <button type="submit">Registruotis</button>
            </form>
        </div>
    </div>
</body>
</html>