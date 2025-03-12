<?php
session_start();
$conn = new mysqli('localhost', 'obezita8ucz', 'pepeknamornik21', 'obezita1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registrace a přihlášení uživatele
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jmeno'], $_POST['prijmeni'], $_POST['email'])) {
    $jmeno = $conn->real_escape_string($_POST['jmeno']);
    $prijmeni = $conn->real_escape_string($_POST['prijmeni']);
    $email = $conn->real_escape_string($_POST['email']);

    // Vložení uživatele do databáze
    $sql = "INSERT INTO uzivatel (jmeno, prijmeni, email) VALUES ('$jmeno', '$prijmeni', '$email')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_name'] = $jmeno;
        echo "<p class='success-message'>Registrace úspěšná, jste přihlášen! Vraťte se prosím na stránku Napište nám pro přidání receptu.</p>";
    } else {
        echo "<p class='error-message'>Chyba: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Napiste</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" >
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="icon" type="image/jpg" href="./img/2logo_matu.png">
    <script src="ham.js"></script>
</head>
<body id="home">
    <nav id="navbar">
        <div id="logo">
            <a href="index.html"><img src="./img/2logo_matu.png" alt="Logo"></a>
        </div>
        <div class="burger-menu" onclick="toggleMenu()">&#9776;</div>
        <ul id="nav-menu">
            <li><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
            <li><a href="Co_je_obezita.html">Poznejte obezitu</a></li>
            <li><a href="Jak_na_obezitu.html">Jak na obezitu</a></li>
            <li><a href="receptar.php">Receptář</a></li>
            <li><a href="napiste.php">Napište nám</a></li>
        </ul>
    </nav>
    <div class="prihlas_container">
        <div class="formular_prihlaseni">
            <h1 id="prihalseni_nadpis">Registrace uživatele
                </h1>

            <form method="post">
                <div class="prihlas_div">
                    <label class="prihlaseni" for="name">Jméno</label>
                    <input class="prihlaseni_pole" type="text" name="jmeno" required><br>
                </div>
                <div class="prihlas_div">
                    <label class="prihlaseni" for="surname">Příjmení</label>
                    <input class="prihlaseni_pole" type="text" name="prijmeni" required><br>
                </div>
                <div class="prihlas_div">
                    <label class="prihlaseni" for="email">E-mail</label>
                    <input class="prihlaseni_pole" type="email" name="email" required><br>
                </div>
                <div class="prihlas_div">
                    <button id="button" type="submit" tabindex="1">
                        <span class="prihlasit_submit"></span>
                        <span id="prihlaseni_text">Registrovat</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <footer id="main-footer">
        <div class="copy-width">
            <p>Maturitní projekt &copy; 2025, Oa Opava</p>
        </div>
    </footer>
</body>
</html>

