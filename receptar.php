<?php
session_start();
$conn = new mysqli('localhost', 'obezita8ucz', 'pepeknamornik21', 'obezita1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL dotaz pro získání receptů a jejich ingrediencí včetně jména a příjmení uživatele
$sql = "SELECT r.id AS recept_id, r.nazev AS recept_nazev, r.popis, r.postup, 
               GROUP_CONCAT(i.nazev SEPARATOR ', ') AS ingredience_nazev,
               u.jmeno, u.prijmeni
        FROM recept r
        LEFT JOIN ingredience_v_receptu ir ON r.id = ir.id_recept
        LEFT JOIN ingredience i ON ir.ingredience_id = i.id
        LEFT JOIN uzivatel u ON r.id_uzivatel = u.id
        GROUP BY r.id, r.nazev, r.popis, r.postup, u.jmeno, u.prijmeni
        ORDER BY r.id DESC"; 

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptář</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" type="image/jpg" href="./img/2logo_matu.png">
    <script src="ham.js"></script>
    <style>
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.container, .Forum {
    flex: 1; /* Obsah se roztáhne na zbývající výšku */
    display: flex;
    flex-direction: column;
}

#main-footer {
    background: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
    width: 100%;
    position: relative;
}
    </style>
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
    <div class="container">
        <div class="con_text" style="background-color: white;">
            <h1 style="font-size: 45px; color: rgb(0, 0, 0); padding-top: 0; padding-bottom: 0;">Vítejte v Receptáři</h1>
            <p style="color: rgb(0, 0, 0); padding-top: 0; margin-top: 0;">Zde naleznete všechny recepty, které vám pomohou v boji proti obezitě.</p>
        </div>
        
        <div class="Forum">
            <div class="Forum_text">
                <?php
            // Pokud máme nějaké recepty
            if ($result->num_rows > 0) {
                // Vypíšeme každý recept v karty místo tabulky
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='recipe-card'>";
                    echo "<h3>" . $row['recept_nazev'] . "</h3>";
                    echo "<p><span class='author'>" . $row['jmeno'] . " " . $row['prijmeni'] . "</span></p>"; 
                    echo "<p><strong>Popis:</strong> " . $row['popis'] . "</p>";
                    echo "<p><strong>Ingredience:</strong> " . $row['ingredience_nazev'] . "</p>";
                    echo "<p><strong>Postup:</strong> " . nl2br($row['postup']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Žádné recepty k zobrazení.</p>";
            }
            
            $conn->close();
            ?>
        </div>
    </div>
</div>

    <footer id="main-footer">
        <div class="copy-width">
            <p>Maturitní projekt &copy; 2025, Oa Opava</p>
        </div>
    </footer>
</body>
</html>