
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
            <ul id="nav-menu">
                <li><a href="#home"><i class="fa-solid fa-house"></i></a></li>
                <li><a href="Co_je_obezita.html">Poznejte obezitu</a></li>
                <li><a href="Jak_na_obezitu.html">Jak na obezitu</a></li>
                <li><a href="receptar.html">Receptář</a></li>
                <li><a href="napiste.html">Napište nám</a></li>
            </ul>
        </nav>
    <div class="prihlas_container">
        <div class="formular_prihlaseni">
            <h1 id="prihalseni_nadpis" >Registrace uživatele</h1>
        <form  method="post">
            <div class="prihlas_div">
            <label class="prihlaseni" for="name">Uživatelské jméno</label>
            <input class="prihlaseni_pole" type="text" name="jmeno" required><br>
            </div>
            <div class="prihlas_div">
            <label class="prihlaseni" for="Telefon">Ingredience</label> 
            <select name="ingredience" id="ingredience" required>
                <?php $conn = new mysqli('localhost', 'obezita8ucz', '', 'obezita1');
                $result = $conn->query("SELECT * FROM ingredience");
                ?>
            </select>
        </div>
        <div class="prihlas_div">
            <label class="prihlaseni" for="Email">E-mail</label>
            <input class="prihlaseni_pole" type="email" name="email" required><br>
        </div>
        <div class="prihlas_div">
            <button id="button" type="submit" tabindex="2">
                <span class="prihlasit_submit"></span>
                <span id="prihlaseni_text">Registrovat</span>
            </button>
        </div>
        </form>
            <h1 id="prihalseni_nadpis">Sdílejte recept</h1>
            <div class="prihlas_div">
                <label class="prihlaseni" for="name">Uživatelské jméno</label>
                <input type="text" class="prihlaseni_pole" id="name" autofocus="" tabindex="1" autocomplete="name" value="">
            </div>
            <div class="prihlas_div">
                <label class="prihlaseni" for="Email">E-mail</label>
                <input type="text" class="prihlaseni_pole" id="Email"  tabindex="1" autocomplete="Email" value="">
            </div>
            <div class="prihlas_div">
                <label class="prihlaseni" for="Telefon">Telefon</label>
                <input type="text" class="prihlaseni_pole" id="Telefon"  tabindex="1" value="">
            </div>
            <div class="prihlas_div">
                <label class="prihlaseni" for="messg">Napište nám</label>  
                <textarea name="messg" id="messg"></textarea>
            </div>
            <div class="prihlas_div">
                <button id="button" type="submit" tabindex="2">
                    <span class="prihlasit_submit"></span>
                    <span id="prihlaseni_text">Odeslat</span>
                </button>
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

