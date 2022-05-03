<?php
include("header.php");
?>
<title>Homepage</title>

<script>
</script>
</head>

<body>

    <?php
    include("./firstNavbar.php");
    include("./secondNavbar.php");
    ?>

    <button class="collegamenti" onclick="location.href='./componenti/comPage.php'"><img src="../immagini/componente.png" alt="Componenti">Componenti</button>
    <button class="collegamenti"><img src="../immagini/computer.png" alt="Dispositivo Informatico">Device</button>
    <button class="collegamenti"><img src="../immagini/strumento.png" alt="Strumenti">Strumenti</button>
    <button class="collegamenti" onclick="location.href='./locali/locPage.php'"><img src="../immagini/locali.png" alt="Locali">Locali</button>
    <button class="collegamenti" onclick="location.href='./armadietti/armPage.php'"><img src="../immagini/armadietto.png" alt="Armadietti">Armadietti</button>
    <?php
    if ($_SESSION['liv'] == 10)
        echo ('<button class="collegamenti"><img src="../immagini/users.png" alt="Utenti">Utenti</button>');
    ?>

    <footer>
        <div>Website created by Jorge Salati Martim</div>
        <a href="https://www.istitutodarzo.edu.it/"><img src="https://i0.wp.com/www.istitutodarzo.edu.it/WP/wp-content/uploads/2021/03/logo-footer3.png?fit=100%2C96&ssl=1" alt="Logo Istituto Silvio d'Arzo"></a>
    </footer>
</body>

</html>