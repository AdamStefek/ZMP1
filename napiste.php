<?php
session_start();
$conn = new mysqli('localhost', 'obezita8ucz', 'pepeknamornik21', 'obezita1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    echo "<p style= 'font-size: 35px;'> Musíte být přihlášeni, abyste mohli přidat recept. <a style= 'font-size: 35px;' href='registrace.php'>Přihlaste se zde</a></p>
    <p style= 'font-size: 35px;'> Nebo se vraťte na naší stránku a jen si ji prohlédněte <a style= 'font-size: 35px;' href='index.html'>Domovská stránka</a></p>";
    exit;
}

// Pokud je uživatel přihlášen, může přidat recept
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pridat_recept'])) {
    $nazev = $conn->real_escape_string($_POST['nazev']);
    $popis = $conn->real_escape_string($_POST['popis']);
    $postup = $conn->real_escape_string($_POST['postup']);
    $uzivatel_id = $_SESSION['user_id'];

    // Vložení receptu do databáze
    $sql = "INSERT INTO recept (nazev, popis, postup, id_uzivatel) VALUES ('$nazev', '$popis', '$postup', '$uzivatel_id')";
    if ($conn->query($sql) === TRUE) {
        $recept_id = $conn->insert_id;

        // Vložení vybraných ingrediencí do tabulky ingredience_v_receptu
        if (isset($_POST['ingredience']) && is_array($_POST['ingredience'])) {
            foreach ($_POST['ingredience'] as $ingredience_id) {
                // Ukládáme recept_id a ingredience_id do tabulky ingredience_v_receptu
                $ingredience_id = (int)$ingredience_id;

                // Vložení ingredience do tabulky ingredience_v_receptu
                $sql = "INSERT INTO ingredience_v_receptu (id_recept, ingredience_id) VALUES ('$recept_id', '$ingredience_id')";
                if (!$conn->query($sql)) {
                    echo "<p class='error-message'>Chyba při přidávání ingredience: " . $conn->error . "</p>";
                }
            }
        }
        echo "<p class='success-message'>Recept byl úspěšně přidán!</p>";
    } else {
        echo "<p class='error-message'>Chyba: " . $conn->error . "</p>";
    }
}


// SQL dotaz pro zobrazení receptů a jejich ingrediencí
$sql = "SELECT r.id AS recept_id, r.nazev AS recept_nazev, GROUP_CONCAT(i.nazev SEPARATOR ', ') AS ingredience_nazev
        FROM recept r
        JOIN ingredience_v_receptu ir ON r.id = ir.id_recept
        JOIN ingredience i ON ir.ingredience_id = i.id
        GROUP BY r.id, r.nazev";

$result = $conn->query($sql);



$conn->close();
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
            <form method="post">
                <h1 id="prihalseni_nadpis">Sdílejte recept</h1>
                <div class="prihlas_div">
                    <label for="nazev">Název receptu:</label>
                    <input type="text" name="nazev" required>
                </div>
                <div class="prihlas_div">
                    <label for="popis">Popis receptu:</label>
                    <input type="text" name="popis" required>
                </div>
                <div class="prihlas_div">
                    <label class="prihlaseni" for="Ingredience">Ingredience</label> 
                    <select id="ingredience" name="ingredience[]" multiple required>
                        <?php
                        $conn = new mysqli('localhost', 'obezita8ucz', 'pepeknamornik21', 'obezita1');
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } 
                        $result = $conn->query("SELECT id, nazev FROM ingredience ORDER BY nazev ASC");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nazev'] . "</option>";
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                    <p class="poznamka">pro výběr více položek držte tlačítko levé Ctrl 
                        <br> prosím o uvedení množství dané ingredience do postupu a chybející ingredience také.

                    </p>
                </div>
                <div class="prihlas_div">
                    <label for="postup">Postup:</label>
                    <textarea name="postup" required></textarea>
                </div>
                <div class="prihlas_div">
                    <button id="button" name="pridat_recept" type="submit" tabindex="2">
                        <span class="prihlasit_submit"></span>
                        Přidat recept
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
