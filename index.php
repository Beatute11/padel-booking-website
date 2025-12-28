<?php
session_start();
if (!isset($_SESSION['vardas'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <body>
        <h1>
            Sveiki, <?php echo $_SESSION['vardas']; ?>!
        </h1>

        <a href="reserve.php">
            <button>Rezervuoti aikštelę</button>
        </a>

        <hr>

        <a href="reservation.php">Atsijungti</a>
    </body>
</html>