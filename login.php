<?php
session_start();
require "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $vardas = $_POST['vardas'];
    $slaptazodis = $_POST['slaptazodis'];

    $stmt = $conn->prepare("SELECT slaptazodis FROM vartotojai WHERE vardas = ?");
    $stmt->bind_param("s", $vardas);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($slaptazodis);
        $stmt->fetch();

        if (password_verify($slaptazodis, $user['slaptazodis'])) {
            die("Prisijungimas pavyko");
            session_start();
            $_SESSION['vardas'] = $user['vardas'];
            exit();
        }
        else {
            die("Neteisingas slaptazodis");
        }
    }
    else {
        die("Neteisingas vartotojo vardas");
    }

    $stmt->close();
    $conn->close();
}
?>