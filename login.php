<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vardas = $_POST['vardas'];
    $inputPassword = $_POST['slaptazodis'];

    $stmt = $conn->prepare("SELECT slaptazodis FROM vartotojai WHERE vardas = ?");
    $stmt->bind_param("s", $vardas);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        if (password_verify($inputPassword, $hashedPassword)) {
            $_SESSION['vardas'] = $vardas;
            header("Location: index.php");
            exit();
        } else {
            echo "Neteisingas slaptazodis";
        }
    } else {
        echo "Neteisingas vartotojo vardas";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/connection.css">
    <title>Prisijungimas</title>
</head>
<body>
    <div class="login_form">
        <h2>Prisijungti prie paskyros</h2>
        <form action="login.php" method="POST">
            <input type="text" name="vardas" placeholder="Vardas" required><br>
            <input type="password" name="slaptazodis" placeholder="Slaptazodis" required><br>
            <button type="submit">Prisijungti</button>
        </form>
        <p class="paskyra">
            <a href="./register.php">Susikurti paskyra</a>
        </p>
    </div>
</body>
</html>