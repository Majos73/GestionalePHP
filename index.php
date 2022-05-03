<?php
include_once './class/users.php';
include_once './config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggUser = new User($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="grafica.css">
    <title>Login</title>
</head>

<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="mb-3" id="form_mail">
        <h1>Login</h1>
        <input type="mail" name="mail" id="mail" placeholder="Email" class="form-control w-75" pattern="(?:prof\.|ata\.|PROF\.|ATA\.|)[a-zA-Z]{3,30}[\.][a-zA-Z]{3,30}@darzo.net" required>
        <input type="submit" value="Invio" name="submit_mail" class="form-control w-25" style="background-color: #ddd;" />
    </form>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="mb-3" style=" display: none;" id="form_otp">
        <h1>Codice OTP</h1>
        <input class="form-control w-75 bottom" type="text" name="otp" id="otp" placeholder="Inserire il codice OTP ricevuto via mail">
        <input type="submit" value="Invio" name="submit_otp" class="form-control w-25 top" style="background-color: #ddd;" />
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

        function change() {
            document.getElementById("form_mail").style.display = "none";
            document.getElementById("form_otp").style.display = "block";
        }
    </script>

    <?php
    if (isset($_POST['submit_mail'])) {
        session_start();
        $_SESSION['mail'] = $_POST['mail'];
        $_SESSION['TS'] = time();
        $_SESSION['strCodice'] = substr(md5(microtime()), 0, 6);
        echo $_SESSION['strCodice'];
        #mail($_SESSION['mail'], "OTP accesso account", $_SESSION['strCodice']);
        echo "<script>change();</script>";
    }

    if (isset($_POST['submit_otp'])) {
        session_start();
        echo ($_POST['otp']);
        if ((time() - $_SESSION['TS']) > 600) {
            echo "<script>tempo();</script>";
            session_destroy();
            session_abort();
            header("refresh:0;url=index.php");
        } else {
            if ($_POST['otp'] == $_SESSION['strCodice']) {
                $oggUser->mail = $_SESSION['mail'];
                $arrayDati = $oggUser->getControlUser();
                $_SESSION['nome'] = $arrayDati[0];
                $_SESSION['cognome'] = $arrayDati[1];
                $_SESSION['liv'] = $arrayDati[2];
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