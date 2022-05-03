<?php
include("../header.php");
include_once("/xampp/htdocs/GestionalePHP/class/componenti.php");
include_once("/xampp/htdocs/GestionalePHP/class/giacenze.php");
include_once("/xampp/htdocs/GestionalePHP/class/categorie.php");
include_once("/xampp/htdocs/GestionalePHP/class/locali.php");
include_once("/xampp/htdocs/GestionalePHP/class/armadietti.php");
include_once("/xampp/htdocs/GestionalePHP/class/cataloghi.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggComp = new Componenti($db);
$oggGiac = new Giacenze($db);
$oggLoc = new Locali($db);
$oggArm = new Armadietti($db);
$oggCateg = new Categorie($db);
$oggCatal = new Cataloghi($db);

$oggComp->id = $_GET['id'];
$datiComponenti = $oggComp->getSingleComponente();

$oggGiac->id_componente = $_GET['id'];
$oggCateg->id = $datiComponenti['ID_Categoria'];
$oggCatal->id = $datiComponenti['ID_Catalogo'];

$datiGiacenze = $oggGiac->getGiacenze();
?>

<title>Componente <?= $_GET['id'] ?></title>
</head>

<body id="<?= $_GET['id'] ?>">
    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <?php
        if ($_SESSION['liv'] == 10) {
        ?>
            <button data-toggle="modal" data-target="#aggiungiGiacenza">Aggiungi Giacenza <i class="fa-solid fa-plus"></i></button>
        <?php
        }
        ?>
    </nav>
    <?php
    include("../secondNavbar.php");
    ?>

    <div class="container-dati">
        <div class="dati">
            <h3>Componente <?= $datiComponenti['nomeComp'] ?>
                <?php
                if ($datiComponenti['immagine']) {
                ?>
                    <a href="#" data-toggle="modal" data-target="#modalImage">
                        <i class="fa-solid fa-image"></i>
                    </a>
                <?php
                }
                ?>
            </h3>
            <p>Sigla = <?= $datiComponenti['sigla'] ?></p>
            <p>Categoria = <?= $oggCateg->getSingleCategoria() ?></p>
            <p>Primo valore = <?= $datiComponenti['valore'] ?> <?= $datiComponenti['umValore'] ?></p>
            <p>Secondo valore = <?= $datiComponenti['valore2'] ?> <?= $datiComponenti['umValore2'] ?> </p>
            <?php
            if ($datiComponenti['note']) {
            ?>
                <p>Note = <?= $datiComponenti['note'] ?></p>
            <?php
            } else {
            ?><p>Note = ---</p>
            <?php
            }
            ?>
            <p>Quantità minima = <?= $datiComponenti['quantitaMin'] ?></p>
            <p>Catalogo = <?= $oggCatal->getSingleCatalogo() ?></p>
        </div>
    </div>

    <div class="container-giacenze">
        <div class="container-table">
            <table id="example" class="display">
                <thead class="dark">
                    <tr>
                        <th>ID</th>
                        <th>Armadietto</th>
                        <th>Posizione</th>
                        <th>Cassetto</th>
                        <th>Locale</th>
                        <th>Quantità</th>
                        <th>Q. spann</th>
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
                    $itemCount = $datiGiacenze->rowCount();

                    if ($itemCount > 0) {
                        $x = 1;
                        while ($row = $datiGiacenze->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $oggArm->id = $row['ID_Armadietto'];
                            $rowArm = $oggArm->getSingleArmadietto();
                            $oggLoc->id = $rowArm['ID_Locale'];
                    ?>
                            <tr>
                                <td> <?= $x ?></td>
                                <td> <?= $rowArm['nomeArmadietto'] ?></td>
                                <td> <?= $row['posizione'] ?></td>
                                <td> <?= $row['nomeCassetto'] ?> </td>
                                <td> <?= $oggLoc->getSingleLocale() ?> </td>
                                <td> <?= $row['quantita'] ?> </td>
                                <td> <?= $row['quantitaSpann'] ?> </td>
                                <?php
                                if ($_SESSION['liv'] == 10) {
                                ?>
                                    <td>
                                        <a onclick="inviaID(this); ottieniDati()" data-toggle="modal" data-target="#modificaGiacenza" id="<?= $row['ID_Giacenza'] ?>">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a onclick="eliminazione(this)" id="<?= $row['ID_Giacenza'] ?>">
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
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <img src="<?= $datiComponenti['immagine'] ?>" alt="Immagine Componente <?= $datiComponenti['nomeComp'] ?>">
            </div>
        </div>
    </div>

    <div class="modal fade" id="modificaGiacenza" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica Giacenza</h5>
                </div>
                <form onsubmit="inviaModifica(); return false;">
                    <div class="modal-body">
                        <label for="campo_armadietto">Armadietto</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_armadietto" id="campo_armadietto" aria-describedby="basic-addon2">
                                <?php
                                $datiArm = $oggArm->getArmadietti();
                                if ($datiArm->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere l'armadietto</option>
                                    <?php
                                    while ($row = $datiArm->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Armadietto'] ?>"><?= $row['nomeArmadietto'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un armadietto</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>

                        <label for="campo_posizione">Posizione</label>
                        <input type="text" class="form-control" name="campo_posizione" id="campo_posizione" placeholder="Inserire la posizione" aria-describedby="basic-addon2">
                        <label for="campo_cassetto">Nome cassetto</label>
                        <input type="text" class="form-control" name="campo_cassetto" id="campo_cassetto" placeholder="Inserire il cassetto">
                        <label for="campo_quantita">Quantità</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="campo_quantita" id="campo_quantita" placeholder="Inserire la quantità">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_quantitaspan">Quantità spannometrica</label>
                        <input type="text" class="form-control" name="campo_quantitaspan" id="campo_quantitaspan" placeholder="Inserire la quantità spannometrica (ex. 3/4)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="inviaModifica()" name="submit_locale" class="btn btn-primary" data-dismiss="modal">Salva</button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="aggiungiGiacenza" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi Giacenza</h5>
                </div>
                <form onsubmit="inviaAggiunta(); return false;">
                    <div class="modal-body">
                        <label for="campo_armadietto_nuovo">Armadietto</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_armadietto_nuovo" id="campo_armadietto_nuovo" aria-describedby="basic-addon2">
                                <?php
                                $datiArm = $oggArm->getArmadietti();
                                if ($datiArm->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere l'armadietto</option>
                                    <?php
                                    while ($row = $datiArm->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Armadietto'] ?>"><?= $row['nomeArmadietto'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un armadietto</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>

                        <label for="campo_posizione_nuovo">Posizione</label>
                        <input type="text" class="form-control" name="campo_posizione_nuovo" id="campo_posizione_nuovo" placeholder="Inserire la posizione" aria-describedby="basic-addon2">
                        <label for="campo_cassetto_nuovo">Nome cassetto</label>
                        <input type="text" class="form-control" name="campo_cassetto_nuovo" id="campo_cassetto_nuovo" placeholder="Inserire il cassetto">
                        <label for="campo_quantita_nuovo">Quantità</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" name="campo_quantita_nuovo" id="campo_quantita_nuovo" placeholder=" Inserire la quantità">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_quantitaspan_nuovo">Quantità spannometrica</label>
                        <input type="text" class="form-control" name="campo_quantitaspan_nuovo" id="campo_quantitaspan_nuovo" placeholder="Inserire la quantità spannometrica (ex. 3/4)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="inviaAggiunta()" name="submit_giacenza" class="btn btn-primary" data-dismiss="modal">Salva</button>
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var idGiacenza;

        window.onload = () => {
            if (!document.body.id) {
                if (alert("Problemi a ottenere i dati del componente. Verrai reindirizzato alla homepage."))
                    location.href = "../homepage.php"
            }

        }

        document.getElementById("modificaGiacenza").addEventListener("keyup", (event) => {
            if (event.keyCode === 13) {
                inviaModifica();
            }
        });

        function inviaID(element) {
            idGiacenza = element.id;
            console.log(idGiacenza);
        }

        function inviaAggiunta() {
            var xhttp = new XMLHttpRequest();

            var armadietto = document.getElementById('campo_armadietto_nuovo').value;
            var posizione = document.getElementById('campo_posizione_nuovo').value;
            var cassetto = document.getElementById('campo_cassetto_nuovo').value;
            var quantita = document.getElementById('campo_quantita_nuovo').value;
            var quantitaSpan = document.getElementById('campo_quantitaspan_nuovo').value;
            var componente = document.body.id;

            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (armadietto && quantita) {
                if (globalRegex.test(posizione) && globalRegex.test(cassetto) &&
                    numRegex.test(quantita)) {

                    const params = {
                        idArmadietto: armadietto,
                        posizione: posizione,
                        cassetto: cassetto,
                        quantita: quantita,
                        quantitaSpan: quantitaSpan,
                        componente: componente
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    xhttp.open("POST", "/GestionalePHP/api/giacenze/creaGiacenza.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./visualizzaComp.php?id=" + componente;
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici e punti. I caratteri speciali accettati nei campi testuali sono - _ \.");
                    document.getElementById('campo_armadietto_nuovo').value = null;
                    document.getElementById('campo_posizione_nuovo').value = null;
                    document.getElementById('campo_cassetto_nuovo').value = null;
                    document.getElementById('campo_quantita_nuovo').value = null;
                    document.getElementById('campo_quantitaspan_nuovo').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function inviaModifica() {
            var xhttp = new XMLHttpRequest();

            var armadietto = document.getElementById('campo_armadietto').value;
            var posizione = document.getElementById('campo_posizione').value;
            var cassetto = document.getElementById('campo_cassetto').value;
            var quantita = document.getElementById('campo_quantita').value;
            var quantitaSpan = document.getElementById('campo_quantitaspan').value;
            var componente = document.body.id;

            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (armadietto && quantita) {
                if (globalRegex.test(posizione) && globalRegex.test(cassetto) &&
                    numRegex.test(quantita)) {

                    const params = {
                        id: idGiacenza,
                        idArmadietto: armadietto,
                        posizione: posizione,
                        cassetto: cassetto,
                        quantita: quantita,
                        quantitaSpan: quantitaSpan,
                        componente: componente
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    xhttp.open("POST", "/GestionalePHP/api/giacenze/modificaGiacenza.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./visualizzaComp.php?id=" + componente;
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici e punti. I caratteri speciali accettati nei campi testuali sono - _ \.");
                    document.getElementById('campo_armadietto').value = null;
                    document.getElementById('campo_posizione').value = null;
                    document.getElementById('campo_cassetto').value = null;
                    document.getElementById('campo_quantita').value = null;
                    document.getElementById('campo_quantitaspan').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function eliminazione(element) {
            var xhttp = new XMLHttpRequest();

            idGiacenza = element.id;
            console.log(idGiacenza);

            const params = {
                id: idGiacenza
            };

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {}
            };

            xhttp.open("POST", "/GestionalePHP/api/giacenze/eliminaGiacenza.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
            setTimeout(function() {
                location.href = "./visualizzaComp.php?id=" + document.body.id;
            }, 500);
        }

        function ottieniDati() {
            var xhttp = new XMLHttpRequest();

            const params = {
                id: idGiacenza
            }

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    if (data['risposta']) {
                        document.getElementById('campo_armadietto').value = data['idArmadietto'];
                        document.getElementById('campo_posizione').value = data['posizione'];
                        document.getElementById('campo_cassetto').value = data['nomeCassetto'];
                        document.getElementById('campo_quantita').value = data['quantita'];
                        document.getElementById('campo_quantitaspan').value = data['quantitaSpann'];
                    } else
                        alert("Problemi con la richiesta. Riprovare.");
                }
            };

            xhttp.open("POST", "/GestionalePHP/api/giacenze/ottieniDatiGiacenza.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        }
    </script>
</body>

</html>