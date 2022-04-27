<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/8af7af9e14.js" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/GestionalePHP/pages/graficaPagine.css">
    <script>
        function noSession() {
            alert("Purtroppo non hai ancora effettuato l'accesso, verrai reindirizzato alla pagina per il login.");
        }

        function closeSession() {
            if (confirm("Effettuare il logout?") == true) {
                navigator.sendBeacon("/GestionalePHP/api/closeSession.php");

                window.location.href = "/GestionalePHP/index.php";
            }
        }

        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <?php
    session_start();
    if ($_SESSION['mail'] == null) {
        echo "<script>noSession();</script>";
        session_abort();
        header("refresh:0;url=/GestionalePHP/index.php");
    }
    ?>