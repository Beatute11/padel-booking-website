<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vartotojo_id'])) {
    header("Location: login.php");
    exit;
}

$vartotojo_id = $_SESSION['vartotojo_id'];

$stmt = $conn->prepare("
    SELECT
        r.id,
        a.pavadinimas AS aikstele,
        r.data,
        r.laikas
    FROM rezervacijos r
    JOIN aiksteles a ON r.aiksteles_id = a.id
    WHERE r.vartotojo_id = ?
    ORDER BY r.data, r.laikas
");

$stmt->bind_param("i", $vartotojo_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Mano rezervacijos</title>
    <link rel="stylesheet" href="styles/home.css">
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

        <h2>Mano rezervacijos</h2>

        <?php if ($result->num_rows === 0): ?>
            <p>Rezervacijų nėra.</p>
        <?php else: ?>
            <table border="1" cellpadding="8">
                <tr>
                    <th>Aikštelė</th>
                    <th>Data</th>
                    <th>Laikas</th>
                    <th>Veiksmai</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['aikstele']) ?></td>
                        <td><?= $row['data'] ?></td>
                        <td><?= substr($row['laikas'], 0, 5) ?></td>
                        <td>
                            <form action="cancel_reservation.php" method="POST" style="display:inline;">
                                <input type="hidden" name="rezervacijos_id" value="<?= $row['id'] ?>">
                                <button id="cancel" type="submit" onclick="return confirm('Ar tikrai norite atšaukti?')">
                                    Atšaukti
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>

        <p><a href="index.php">← Grįžti į pagrindinį</a></p>

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

<?php
$stmt->close();
$conn->close();
?>

