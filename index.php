<?php

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
    <form action="homepage.php" method="POST" class="mb-3" onsubmit="return OTPCode(this);">
        <h1>Login</h1>
        <input type="email" name="mail" id="mail" placeholder="Email" class="form-control w-75" pattern="(?:prof|ata)+[a-z0-9.]{2,61}@darzo.net" required>
        <input class="form-control w-75" type="text" id="otp" placeholder="Codice OTP" disabled>
        <input type="submit" value="Invio" class="form-control w-25" style="background-color: #ddd;" />
    </form>
    <button class="btn bottom">Guest</button>
    <script>
        function OTPCode(form) {
            console.log(" ciao");
            var mail = document.getElementById(mail);
            var otp = document.getElementById(otp);
            mail.disabled = true;
        }
    </script>
</body>

</html>