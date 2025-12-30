<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

/* ============
     POST
=============== */

$success = false;
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $vartotojo_id = $_SESSION['vartotojo_id'];
    $aiksteles_id = $_POST['aiksteles_id'];
    $data         = $_POST['data'];
    $laikas       = $_POST['laikas'];

    // tikrinti ar laikas uzimtas
    $check = $conn->prepare(
        "SELECT id FROM rezervacijos
         WHERE aiksteles_id = ? AND data = ? AND laikas = ?"
    );
    $check->bind_param("iss", $aiksteles_id, $data, $laikas);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Šis laikas jau užimtas!";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO rezervacijos (vartotojo_id, aiksteles_id, data, laikas)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiss", $vartotojo_id, $aiksteles_id, $data, $laikas);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Klaida: " . $conn->error;
        }
    }
}

/* ============
     GET
=============== */

// aiksteles
$aiksteles = $conn->query("SELECT * FROM aiksteles");

// data
$pasirinkta_data = $_GET['data'] ?? date('Y-m-d');
$aiksteles_id = $_GET['aiksteles_id'] ?? null;

// rezervuoti laikai
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

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home.css">
    <title>Padelis</title>
</head>

<body>
    <header>
        <img src="static/logo.jpg" alt="logotipas" height="60">
        <div class="contents">
            <a href="index.php#apie" class="cont-link">Apie</a>
            <a href="index.php#rezervacija" class="cont-link">Rezervacija</a>
            <a href="index.php#iranga" class="cont-link">Iranga</a>
            <a href="index.php#kontaktai" class="cont-link">Kontaktai</a>
        </div>
        <div class="profile">
            <button id="profileBtn">
                <?= htmlspecialchars($_SESSION['vardas']) ?>
            </button>
            <div id="dropdown">
                <a href="my_reservations.php" >Mano rezervacijos</a>
                <a href="login.php">Atsijungti</a>
            </div>
        </div>
    </header>

    <?php if ($success): ?>
    <div class="success-box">
        <h2>Rezervacija sėkminga!</h2>
        <p>Jūsų rezervacija patvirtinta.</p>
        <a href="index.php" class="btn">Į pagrindinį</a>
        <a href="reservation.php" class="btn reserve">Rezervuoti kitą</a>
    </div>

    <?php elseif ($error): ?>
        <div class="error-box">
            <h2><?= htmlspecialchars($error) ?></h2>
            <a href="reservation.php" class="btn">Grįžti</a>
        </div>

    <?php else: ?>


    <h2>Rezervacija</h2>

    <div class="container">
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

        <p>Data:</p><br>
        <input type="date"
               name="data"
               value="<?= $pasirinkta_data ?>"
               min="<?= date('Y-m-d') ?>"
               onchange="this.form.submit()">

        </form>

        <p>Laikas:</p><br>
        <?php
        if ($aiksteles_id):

            $start = strtotime("08:00");
            $end   = strtotime("22:00");
            $step  = 30 * 60;

            for ($time = $start; $time < $end; $time += $step):
                $slot = date("H:i", $time);

                if (in_array($slot, $uzimti_laikai)):
                    echo "<span class='slot-taken'>$slot</span>";
                else:
        ?>
                <form method="POST" style="display:inline">
                    <input type="hidden" name="aiksteles_id" value="<?= $aiksteles_id ?>">
                    <input type="hidden" name="data" value="<?= $pasirinkta_data ?>">
                    <input type="hidden" name="laikas" value="<?= $slot ?>">
                    <button class="slot free"><?= $slot ?></button>
                </form>
        <?php
            endif;
            endfor;
        ?>

       <?php else: ?>
            <p>Pasirinkite aikštelę ir datą</p>
       <?php endif; ?>
       <?php endif; ?>
    </div>

    <script>
        document.getElementById("profileBtn")?.addEventListener("click", function () {
            const dropdown = document.getElementById("dropdown");
            dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function (e) {
            if (!e.target.closest(".profile")) {
                const dropdown = document.getElementById("dropdown");
                if (dropdown) dropdown.style.display = "none";
            }
        });
    </script>
</body>
</html>
