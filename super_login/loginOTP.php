<?php
session_start();
include("../pages/header.php");
?>
    <title>Codice OTP admin</title>
</head>

<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <h1>Codice OTP</h1>
        <input class="form-control w-75 bottom" type="text" name="otp" id="otp" placeholder="Inserire il codice OTP ricevuto via mail">
        <p id="text"><?php $_SESSION['strCodice'] ?></p>
        <input type="submit" value="Invio" class="form-control w-25 top" style="background-color: #ddd;" />
    </form>

    <script>
        function errore() {
            alert("Il codice inserito non è corretto, si prega di riprovare.");
        }

        function tempo() {
            alert("E' stato superato il tempo limite, si prega di riprovare.");
        }

        function corretto() {
            alert("Il codice inserito è corretto, verrai indirizzato alla pagina protetta.");
        }
    </script>

    <?php
    echo $_SESSION['strCodice'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ((time() - $_SESSION['TS']) > 600) {
            echo "<script>tempo();</script>";
            session_abort();
            header("refresh:0;url=index.php");
        } else {
            if ($_POST['otp'] == $_SESSION['strCodice']) {
                echo "<script>corretto();</script>";
                header("refresh:0;url=./pages/homepage.php");
            } else {
                echo "<script>errore();</script>";
            }
        }
    }
    ?>
</body>

</html>