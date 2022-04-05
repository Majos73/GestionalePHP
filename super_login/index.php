<?php
include("../pages/header.php");
?>
    <title>Login Admin</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $_SESSION['mail'] = $_POST['mail'];
        $_SESSION['TS'] = time();
        $strRandom = md5(microtime());
        $_SESSION['strCodice'] = substr($strRandom, 0, 6);
        echo $_SESSION['strCodice'];
        #mail($_SESSION['mail'], "OTP accesso account", $_SESSION['strCodice']);
        header('location: loginOTP.php');
    }
    ?>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="mb-3">
        <h1>Login Admin</h1>
        <input type="mail" name="mail" id="mail" placeholder="Email" class="form-control w-75" pattern="(?:prof|ata|)[a-z0-9.]{2,61}@darzo.net" required>
        <input type="submit" value="Invio" class="form-control w-25" style="background-color: #ddd;" />
    </form>
</body>

</html>