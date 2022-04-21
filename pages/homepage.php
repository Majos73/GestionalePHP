<?php
include("header.php");
?>
<title>Homepage</title>
</head>

<body>

    <?php
    include("./navbar.php");
    ?>

    <button class="collegamenti" onclick="componenti()"><img src="../immagini/componente.png" alt="Componenti">Componenti</button>
    <button class="collegamenti"><img src="../immagini/computer.png" alt="Dispositivo Informatico">Device</button>
    <button class="collegamenti"><img src="../immagini/strumento.png" alt="Componenti">Strumenti</button>
    <button class="collegamenti"><img src="../immagini/locali.png" alt="Componenti">Locali</button>
    <button class="collegamenti"><img src="../immagini/armadietto.png" alt="Componenti">Armadietti</button>
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