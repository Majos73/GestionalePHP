<?php
include("../header.php");
include_once("/xampp/htdocs/GestionalePHP/class/locali.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggLoc = new Locali($db);
$datiLocali = $oggLoc->getLocali();
?>

<title>Locali</title>
</head>

<body>

    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <?php
        if ($_SESSION['liv'] == 10) { ?>
            <button data-toggle="modal" data-target="#aggiungiLocale">Nuovo Locale <i class="fa-solid fa-plus"></i></button>
        <?php
        }
        ?>

    </nav>
    <?php
    include("../secondNavbar.php");
    ?>


    <div class="container-table">
        <table id="example" class="display">
            <thead class="dark">
                <tr>
                    <th>ID</th>
                    <th>Locale</th>
                    <?php
                    if ($_SESSION['liv'] == 10) {
                        echo "<th>Opzioni</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $itemCount = $datiLocali->rowCount();

                if ($itemCount > 0) {
                    $x = 1;
                    while ($row = $datiLocali->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                ?>
                        <tr>
                            <td> <?= $x ?> </td>
                            <td> <?= $row['locale'] ?> </td>
                            <?php
                            if ($_SESSION['liv'] == 10) {
                            ?>
                                <td>
                                    <a onclick="inviaID(this); ottieniDati()" data-toggle="modal" data-target="#modificaLocale" id="<?= $row['ID_Locale'] ?>">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a onclick="eliminazione(this)" id="<?= $row['ID_Locale'] ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            <?php
                            }
                            ?>

                        </tr>
                    <?php
                        $x++;
                    }
                } else {
                    ?>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modificaLocale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica</h5>
                </div>
                <form onsubmit="inviaModifica(); return false;">
                    <div class="modal-body">
                        <label for="campo-locale">Nome del locale</label>
                        <input type="text" class="form-control" name="campo_locale" id="campo_locale" placeholder="Inserire il locale" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="inviaModifica()" name="submit_locale" class="btn btn-primary" data-dismiss="modal">Salva</button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="aggiungiLocale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuovo locale</h5>
                </div>
                <form onsubmit="inviaAggiunta(); return false;">
                    <div class="modal-body">
                        <label for="campo-locale">Nome del locale</label>
                        <input type="text" class="form-control" name="campo_locale_nuovo" id="campo_locale_nuovo" placeholder="Inserire il nuovo locale" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="inviaAggiunta()" name="submit_locale_nuovo" class="btn btn-primary" data-dismiss="modal">Salva</button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var idLocale;

        document.getElementById("modificaLocale").addEventListener("keyup", (event) => {
            if (event.keyCode === 13) {
                inviaModifica();
            }
        })

        function inviaID(element) {
            idLocale = element.id;
            console.log(idLocale);
        }

        function inviaModifica() {
            var xhttp = new XMLHttpRequest();
            var loc = document.getElementById('campo_locale').value;
            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            if (loc) {
                if (globalRegex.test(loc)) {
                    const params = {
                        id: idLocale,
                        locale: loc
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    console.log(params['id']);
                    console.log(params['locale']);

                    xhttp.open("POST", "/GestionalePHP/api/locali/modificaLocale.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./locPage.php";
                    }, 500);
                } else {
                    alert("Caratteri speciali accettati solo _ e -");
                    document.getElementById('campo_locale').value = null;
                }
            } else {
                alert("Inserire un valore");
            }
        }

        function inviaAggiunta() {
            var xhttp = new XMLHttpRequest();
            var loc = document.getElementById('campo_locale_nuovo').value;
            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            if (loc) {
                if (globalRegex.test(loc)) {
                    const params = {
                        locale: loc
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    console.log(params['locale']);

                    xhttp.open("POST", "/GestionalePHP/api/locali/creaLocale.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./locPage.php";
                    }, 500);
                } else {
                    alert("Caratteri speciali accettati solo _ e -");
                    document.getElementById('campo_locale').value = null;
                }
            } else {
                alert("Inserire un valore");
            }
        }

        function eliminazione(element) {
            if(confirm("Sei sicuro di voler eliminare il locale?")){
            var xhttp = new XMLHttpRequest();

            idLocale = element.id;
            console.log(idLocale);

            const params = {
                id: idLocale
            };

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    alert(data['Risposta']);
                }
            };

            xhttp.open("POST", "/GestionalePHP/api/locali/eliminaLocale.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
            setTimeout(function() {
                location.href = "./locPage.php";
            }, 500);
        }
        }

        function ottieniDati() {
            var xhttp = new XMLHttpRequest();

            const params = {
                id: idLocale
            }

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    if (data['risposta'])
                        document.getElementById('campo_locale').value = data['locale'];
                    else
                        alert("Problemi con la richiesta. Riprovare.");
                }
            };

            xhttp.open("POST", "/GestionalePHP/api/locali/ottieniDatiLocale.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        }
    </script>
</body>

</html>