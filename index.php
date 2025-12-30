<?php
session_start();
if (!isset($_SESSION['vardas'])) {
    header("Location: login.php");
    exit;
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
                <a href="#apie" class="cont-link">Apie</a>
                <a href="#rezervacija" class="cont-link">Rezervacija</a>
                <a href="#iranga" class="cont-link">Iranga</a>
                <a href="#kontaktai" class="cont-link">Kontaktai</a>
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

        <h1>
            Sveiki, <?php echo $_SESSION['vardas']; ?>!
        </h1>

        <section id="apie">
            <h2>Apie</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat.
                    In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla
                    lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class
                    aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos. Lorem ipsum dolor sit amet consectetur
                    adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis.
                    Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa
                    nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent
                    per conubia nostra inceptos himenaeos. Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex
                    sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam
                    urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer
                    nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.
                    Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam
                    semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem.
                    Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet
                    orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat,
                    leo eget bibendum sodales, augue velit cursus nunc.
                </p>
        </section>

        <div class="photo-container">
            <div class="scroll">
                <div class="photo-line">
                    <img src="static/rocket2.jpeg" alt="1 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="2 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="3 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="4 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="5 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="6 nuotrauka">
                </div>

                <div class="photo-line">
                    <img src="static/rocket2.jpeg" alt="1 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="2 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="3 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="4 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="5 nuotrauka">
                    <img src="static/rocket2.jpeg" alt="6 nuotrauka">
                </div>
            </div>
        </div>

        <section id="rezervacija">
            <a href="reservation.php">
                <button id="reservation">Rezervuoti aikštelę</button>
            </a>
        </section>

        <section id="iranga">
            <h2>Iranga</h2>
            <h3>Lounge zona</h3>
                <p>Jauki ir patogi vieta, kur galėsite atsipalaiduoti, aptarti idėjas, pasidalinti dienos įspūdžiais
                    ar diskutuoti apie žaidimo rezultatus su bičiuliais. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
                    ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo,
                    fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                </p>

            <h3>Maisto paslaugos</h3>
                <p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.
                    Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                    Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper
                    ultricies nisi.
                </p>

            <h3>Irangos nuoma</h3>
                <p>Galite išsinuomoti arba įsigyti viską, ko reikia žaidimui. Siūlome platų „Bullpadel“ prekių asortimentą. Nullam dictum felis eu pede
                    mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula,
                    porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra
                    nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.
                </p>

            <h3>Irangos pardavimas</h3>
                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                    Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.
                    Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                    Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.
                </p>
        </section>

        <section id="kontaktai">
            <h2>Kontaktai</h2>
            <p>

            </p>
        </section>

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