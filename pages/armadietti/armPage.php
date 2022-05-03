<?php
include("../header.php");
include_once("/xampp/htdocs/GestionalePHP/class/locali.php");
include_once("/xampp/htdocs/GestionalePHP/class/armadietti.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggLoc = new Locali($db);
$oggArm = new Armadietti($db);
$datiArmadietti = $oggArm->getArmadietti();
?>

<title>Armadietti</title>
</head>

<body>

    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <button onclick="location.href='/GestionalePHP/pages/locali/locPage.php'" class="aggiunte">Locali <i class="fa-solid fa-eye"></i></button>

        <?php
        if ($_SESSION['liv'] == 10) { ?>
            <button data-toggle="modal" data-target="#aggiungiArmadietto">Aggiungi Armadietto <i class="fa-solid fa-plus"></i></button>
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
                    <th>Armadietto</th>
                    <th>Ripiani</th>
                    <th>Numero porte</th>
                    <th>Larghezza</th>
                    <th>Lunghezza</th>
                    <th>Altezza</th>
                    <th>Locale</th>
                    <?php
                    if ($_SESSION['liv'] == 10) {
                    ?>
                        <th>Opzioni</th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $itemCount = $datiArmadietti->rowCount();

                if ($itemCount > 0) {
                    $x = 1;
                    while ($row = $datiArmadietti->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $oggLoc->id = $row['ID_Locale'];

                ?>
                        <tr>
                            <td> <?= $x ?> </td>
                            <td> <?= $row['nomeArmadietto'] ?></td>
                            <td> <?= $row['ripiani'] ?> </td>
                            <td> <?= $row['numPorte'] ?> </td>
                            <td> <?= $row['larghezza'] ?> </td>
                            <td> <?= $row['lunghezza'] ?> </td>
                            <td> <?= $row['altezza'] ?> </td>
                            <td>
                                <?= $oggLoc->getSingleLocale() ?> </td>
                            <?php
                            if ($_SESSION['liv'] == 10) {
                            ?>
                                <td>
                                    <a onclick="inviaID(this); ottieniDati()" data-toggle="modal" data-target="#modificaLocale" id="<?= $row['ID_Armadietto'] ?>">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a onclick="eliminazione(this)" id="<?= $row['ID_Armadietto'] ?>">
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
                        <td> </td>
                        <td> </td>
                        <td> </td>
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
                        <label for="campo_armadietto">Nome dell'armadietto</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="campo_armadietto" id="campo_armadietto" placeholder="Inserire l'armadietto" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_ripiani">Numero ripiani</label>
                        <input type="number" class="form-control" name="campo_ripiani" id="campo_ripiani" placeholder="Inserire il numero di ripiani">
                        <label for="campo_numporte">Numero di porte</label>
                        <input type="number" class="form-control" name="campo_numporte" id="campo_numporte" placeholder="Inserire il numero di porte">
                        <label for="campo_larghezza">Larghezza</label>
                        <input type="number" class="form-control" name="campo_larghezza" id="campo_larghezza" placeholder="Inserire la larghezza">
                        <label for="campo_lunghezza">Lunghezza</label>
                        <input type="number" class="form-control" name="campo_lunghezza" id="campo_lunghezza" placeholder="Inserire la lunghezza">
                        <label for="campo_altezza">Altezza</label>
                        <input type="number" class="form-control" name="campo_altezza" id="campo_altezza" placeholder="Inserire l'altezza">
                        <label for="campo_idlocale">Locale</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_idlocale" id="campo_idlocale" aria-describedby="basic-addon2">
                                <?php
                                $datiLocali = $oggLoc->getLocali();
                                if ($datiLocali->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il locale</option>
                                    <?php
                                    while ($row = $datiLocali->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Locale'] ?>"><?= $row['locale'] ?></option>
                                        <script>
                                            console.log(<?= $row['ID_Locale'] ?>)
                                        </script>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un locale</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="inviaModifica()" name="submit_locale" class="btn btn-primary" data-dismiss="modal">Salva</button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="aggiungiArmadietto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuovo locale</h5>
                </div>
                <form onsubmit="inviaAggiunta(); return false;">
                    <div class="modal-body">
                        <label for="campo_armadietto_nuovo">Nome dell'armadietto</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="campo_armadietto_nuovo" id="campo_armadietto_nuovo" placeholder="Inserire il nuovo armadietto" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_ripiani_nuovo">Numero ripiani</label>
                        <input type="number" class="form-control" name="campo_ripiani_nuovo" id="campo_ripiani_nuovo" placeholder="Inserire il numero di ripiani">
                        <label for="campo_numporte_nuovo">Numero di porte</label>
                        <input type="number" class="form-control" name="campo_numporte_nuovo" id="campo_numporte_nuovo" placeholder="Inserire il numero di porte">
                        <label for="campo_larghezza_nuovo">Larghezza</label>
                        <input type="number" class="form-control" name="campo_larghezza_nuovo" id="campo_larghezza_nuovo" placeholder="Inserire la larghezza">
                        <label for="campo_lunghezza_nuovo">Lunghezza</label>
                        <input type="number" class="form-control" name="campo_lunghezza_nuovo" id="campo_lunghezza_nuovo" placeholder="Inserire la lunghezza">
                        <label for="campo_altezza_nuovo">Altezza</label>
                        <input type="number" class="form-control" name="campo_altezza_nuovo" id="campo_altezza_nuovo" placeholder="Inserire l'altezza">
                        <label for="campo_idlocale_nuovo">Locale</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_idlocale_nuovo" id="campo_idlocale_nuovo" aria-describedby="basic-addon2">
                                <?php
                                $datiLocali = $oggLoc->getLocali();
                                if ($datiLocali->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il locale</option>
                                    <?php
                                    while ($row = $datiLocali->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Locale'] ?>"><?= $row['locale'] ?></option>
                                        <script>
                                            console.log(<?= $row['ID_Locale'] ?>)
                                        </script>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un locale</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
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
        var idArmadietto;

        document.getElementById("modificaLocale").addEventListener("keyup", (event) => {
            if (event.keyCode === 13) {
                inviaModifica();
            }
        })

        function inviaID(element) {
            idArmadietto = element.id;
            console.log(idArmadietto);
        }

        function inviaModifica() {
            var xhttp = new XMLHttpRequest();

            var armadietto = document.getElementById('campo_armadietto').value;
            var rip = document.getElementById('campo_ripiani').value;
            var numP = document.getElementById('campo_ripiani').value;
            var larg = document.getElementById('campo_larghezza').value;
            var lung = document.getElementById('campo_lunghezza').value;
            var alt = document.getElementById('campo_altezza').value;
            var loc = document.getElementById('campo_idlocale').value;

            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (armadietto && loc) {
                if (numRegex.test(loc) && numRegex.test(alt) && numRegex.test(lung) &&
                    numRegex.test(larg) && numRegex.test(numP) && numRegex.test(rip) &&
                    globalRegex.test(armadietto)) {

                    const params = {
                        id: idArmadietto,
                        armadietto: armadietto,
                        ripiani: rip,
                        numeroPorte: numP,
                        larghezza: larg,
                        lunghezza: lung,
                        altezza: alt,
                        id_locale: loc
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    console.log(params['id']);

                    xhttp.open("POST", "/GestionalePHP/api/armadietti/modificaArmadietto.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./armPage.php";
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici. I caratteri speciali accettati nel nome sono - e _.");
                    document.getElementById('campo_armadietto').value = null;
                    document.getElementById('campo_ripiani').value = null;
                    document.getElementById('campo_ripiani').value = null;
                    document.getElementById('campo_larghezza').value = null;
                    document.getElementById('campo_lunghezza').value = null;
                    document.getElementById('campo_altezza').value = null;
                    document.getElementById('campo_idlocale').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function inviaAggiunta() {
            var xhttp = new XMLHttpRequest();

            var armadietto = document.getElementById('campo_armadietto_nuovo').value;
            var rip = document.getElementById('campo_ripiani_nuovo').value;
            var numP = document.getElementById('campo_ripiani_nuovo').value;
            var larg = document.getElementById('campo_larghezza_nuovo').value;
            var lung = document.getElementById('campo_lunghezza_nuovo').value;
            var alt = document.getElementById('campo_altezza_nuovo').value;
            var loc = document.getElementById('campo_idlocale_nuovo').value;

            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (armadietto && document.getElementById('campo_idlocale_nuovo').value) {

                console.log(loc);
                if (numRegex.test(loc) && numRegex.test(alt) && numRegex.test(lung) &&
                    numRegex.test(larg) && numRegex.test(numP) && numRegex.test(rip) &&
                    globalRegex.test(armadietto)) {

                    const params = {
                        armadietto: armadietto,
                        ripiani: rip,
                        numeroPorte: numP,
                        larghezza: larg,
                        lunghezza: lung,
                        altezza: alt,
                        id_locale: loc
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    xhttp.open("POST", "/GestionalePHP/api/armadietti/creaArmadietto.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./armPage.php";
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici. I caratteri speciali accettati nel nome sono - e _.");
                    document.getElementById('campo_armadietto_nuovo').value = null;
                    document.getElementById('campo_ripiani_nuovo').value = null;
                    document.getElementById('campo_ripiani_nuovo').value = null;
                    document.getElementById('campo_larghezza_nuovo').value = null;
                    document.getElementById('campo_lunghezza_nuovo').value = null;
                    document.getElementById('campo_altezza_nuovo').value = null;
                    document.getElementById('campo_idlocale_nuovo').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function eliminazione(element) {
            var xhttp = new XMLHttpRequest();

            idArmadietto = element.id;
            console.log(idArmadietto);

            const params = {
                idArmadietto: idArmadietto
            };

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {}
            };

            xhttp.open("POST", "/GestionalePHP/api/armadietti/eliminaArmadietto.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
            setTimeout(function() {
                location.href = "./armPage.php";
            }, 500);
        }

        function ottieniDati() {
            var xhttp = new XMLHttpRequest();

            const params = {
                id: idArmadietto
            }

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    if (data['risposta']) {
                        document.getElementById('campo_armadietto').value = data['nome'];
                        document.getElementById('campo_ripiani').value = data['ripiani'];
                        document.getElementById('campo_numporte').value = data['numPorte'];
                        document.getElementById('campo_larghezza').value = data['larghezza'];
                        document.getElementById('campo_lunghezza').value = data['lunghezza'];
                        document.getElementById('campo_altezza').value = data['altezza'];
                        document.getElementById('campo_idlocale').value = data['locale'];
                    } else
                        alert("Problemi con la richiesta. Riprovare.");
                }
            };

            xhttp.open("POST", "/GestionalePHP/api/armadietti/ottieniDatiArmadietto.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        }
    </script>
</body>

</html>