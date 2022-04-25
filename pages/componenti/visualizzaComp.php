<?php
include("../header.php");
?>
<title>Componente <?= $_GET['id'] ?></title>
</head>

<body>
    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <button data-toggle="modal" data-target="#aggiungiLocale">Aggiungi Locale <i class="fa-solid fa-plus"></i></button>
    </nav>
    <?php
    include("../secondNavbar.php");
    ?>
</body>

</html>