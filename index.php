<!DOCTYPE html>
<html>
<head>
    <title>Prisijungimas</title>
</head>
<body>
    <h2>Prisijungimas</h2>
    <form action="login.php" method="POST">
        <input type="text" name="vardas" placeholder="Vardas" required><br>
        <input type="password" name="slaptazodis" placeholder="Slaptazodis" required><br>
        <button type="submit">Prisijungti</button>
    </form>

    <hr>

    <h2>Registracija</h2>
    <form action="register.php" method="POST">
        <input type="text" name="vardas" placeholder="Vardas" required><br>
        <input type="email" name="el_pastas" placeholder="El. Pastas" required><br>
        <input type="password" name="slaptazodis" placeholder="Slaptas" required><br>
        <button type="submit">Registruotis</button>
    </form>
</body>
</html>
