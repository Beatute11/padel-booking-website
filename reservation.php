<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

// Gauti aikšteles
$aiksteles = $conn->query("SELECT * FROM aiksteles");
?>

<h2>Rezervacija</h2>

<form action="rezervuoti.php" method="POST">

    <label>Aikštelė:</label><br>
    <select name="aiksteles_id" required>
        <?php while ($row = $aiksteles->fetch_assoc()): ?>
            <option value="<?= $row['id']; ?>">
                <?= $row['pavadinimas']; ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Data:</label><br>
    <input type="date" name="data" required><br><br>

    <label>Laikas:</label><br>
    <input type="time" name="laikas" required><br><br>

    <button type="submit">Rezervuoti</button>

</form>
