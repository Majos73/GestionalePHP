<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="grafica.css">
    <title>Document</title>
</head>

<body>
    <form action="<? $_SERVER['PHP_SELF'] ?>" method="POST">
        <h1>Login</h1>
        <input class="form-control w-75 bottom" type="text" id="otp" placeholder="Inserire il codice OTP ricevuto via mail">
        <input type="submit" value="Invio" class="form-control w-25 top" style="background-color: #ddd;" />
    </form>
</body>

</html>