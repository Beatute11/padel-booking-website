<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

// Courts
$aiksteles = $conn->query("SELECT * FROM aiksteles");

// Selected values
$pasirinkta_data = $_GET['data'] ?? date('Y-m-d');
$aiksteles_id = $_GET['aiksteles_id'] ?? null;

// Get reserved times
$uzimti_laikai = [];

if ($aiksteles_id) {
    $stmt = $conn->prepare(
        "SELECT laikas FROM rezervacijos
         WHERE aiksteles_id = ? AND data = ?"
    );
    $stmt->bind_param("is", $aiksteles_id, $pasirinkta_data);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $uzimti_laikai[] = substr($row['laikas'], 0, 5);
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home.css">
    <title>Padelis</title>
</head>

    <header>
        <img src="static/logo.jpg" alt="logotipas" height="60">
        <div class="contents">
            <a href="#apie" class="cont-link">Apie</a>
            <a href="#rezervacija" class="cont-link">Rezervacija</a>
            <a href="#iranga" class="cont-link">Iranga</a>
            <a href="#kontaktai" class="cont-link">Kontaktai</a>
        </div>
    </header>

<h2>Rezervacija</h2>

<form method="GET">

    <p>Pasirinkite aikštelę:</p>
    <?php while ($row = $aiksteles->fetch_assoc()): ?>
        <label>
            <input type="radio"
                   name="aiksteles_id"
                   value="<?= $row['id']; ?>"
                   <?= ($row['id'] == $aiksteles_id) ? 'checked' : '' ?>
                   required
                   onchange="this.form.submit()">
            <?= $row['pavadinimas']; ?>
        </label><br>
    <?php endwhile; ?>

    <br>

    <label>Data:</label><br>
    <input type="date"
           name="data"
           value="<?= $pasirinkta_data ?>"
           min="<?= date('Y-m-d') ?>"
           onchange="this.form.submit()">

</form>

<label>Laikas:</label><br>
<?php
if ($aiksteles_id):

    $start = strtotime("08:00");
    $end   = strtotime("22:00");
    $step  = 30 * 60;

    for ($time = $start; $time < $end; $time += $step):

        $slot = date("H:i", $time);

        if (in_array($slot, $uzimti_laikai)):
            echo "<span class='slot taken'>$slot</span>";
        else:
?>
            <form method="POST" action="reserve.php" style="display:inline">
                <input type="hidden" name="aiksteles_id" value="<?= $aiksteles_id ?>">
                <input type="hidden" name="data" value="<?= $pasirinkta_data ?>">
                <input type="hidden" name="laikas" value="<?= $slot ?>">
                <button class="slot free"><?= $slot ?></button>
            </form>
<?php
        endif;
    endfor;

else:
    echo "Pasirinkite aikštelę ir datą";
endif;
?>
