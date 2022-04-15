<?php
include("header.php");
?>
</head>

<body>
    <?php
    session_start();
    echo ($_SESSION['mail']);
    echo ($_SESSION['liv']);
    if ($_SESSION['mail'] == null) {
        echo "<script>noSession();</script>";
        session_abort();
        header("refresh:0;url=../index.php");
    }

    ?>
</body>

</html>