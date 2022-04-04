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

    function setGuest(){
        session_start();
        $_SESSION['mail'] = "guest";
        $_SESSION['TS'] = time();
        header('location: homepage.php');
    }
    ?>

    <script>
        function callGuest(){
            
        }
    </script>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="mb-3">
        <h1>Login</h1>
        <input type="mail" name="mail" id="mail" placeholder="Email" class="form-control w-75" pattern="(?:prof|ata|)[a-z0-9.]{2,61}@darzo.net" required>
        <input type="submit" value="Invio" class="form-control w-25" style="background-color: #ddd;" />
    </form>
    <button class="btn bottom" type="submit" onclick="<?php echo setGuest();?> ">Guest</button>


</body>

</html>