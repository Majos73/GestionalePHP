<?php
include("../header.php");
include_once("/xampp/htdocs/GestionalePHP/class/componenti.php");
include_once("/xampp/htdocs/GestionalePHP/class/categorie.php");
include_once("/xampp/htdocs/GestionalePHP/class/cataloghi.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggComp = new Componenti($db);
$oggCateg = new Categorie($db);
$oggCatal = new Cataloghi($db);
$datiComponenti = $oggComp->getComponentiPerTable();
?>


<title>Componenti</title>
</head>

<body>
    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <button data-toggle="modal" data-target="#aggiungiComponente">Aggiungi Componente <i class="fa-solid fa-plus"></i></button>
    </nav>
    <?php
    include("../secondNavbar.php");
    ?>


    <div class="container-table">
        <table id="example" class="display">
            <thead class="dark">
                <tr>
                    <th>ID</th>
                    <th>Componente</th>
                    <th>Sigla</th>
                    <th>Categoria</th>
                    <th>Catalogo</th>
                    <th>Opzioni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $itemCount = $datiComponenti->rowCount();

                if ($itemCount > 0) {
                    $x = 1;
                    while ($row = $datiComponenti->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $oggCatal->id = $row['ID_Catalogo'];
                        $oggCateg->id = $row['ID_Categoria'];
                ?>
                        <tr>
                            <td> <?= $x ?> </td>
                            <td> <?= $row['nomeComp'] ?></td>
                            <td> <?= $row['sigla'] ?> </td>
                            <td> <?= $oggCateg->getSingleCategoria() ?> </td>
                            <td> <?= $oggCatal->getSingleCatalogo() ?> </td>
                            <td>
                                <a onclick="inviaID(this); ottieniDati()" data-toggle="modal" data-target="#modificaComponente" id="<?= $row['ID_Componente'] ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a onclick="eliminazione(this)" id="<?= $row['ID_Componente'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <a onclick="visualizza(this)" id="<?= $row['ID_Componente'] ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
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
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modificaComponente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica</h5>
                </div>
                <form onsubmit="inviaModifica(); return false;">
                    <div class="modal-body">
                        <label for="campo_componente">Nome del componente</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="campo_componente" id="campo_componente" placeholder="Inserire il componente" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_sigla">Sigla</label>
                        <input type="text" class="form-control" name="campo_sigla" id="campo_sigla" placeholder="Inserire la sigla">
                        <label for="campo_valore">Valore</label>
                        <input type="number" class="form-control" name="campo_valore" id="campo_valore" placeholder="Inserire il valore">
                        <label for="campo_umvalore">Unità di misura</label>
                        <input type="text" class="form-control" name="campo_umvalore" id="campo_umvalore" placeholder="Inserire l'unità di misura del primo valore">
                        <label for="campo_valore2">Valore 2</label>
                        <input type="number" class="form-control" name="campo_valore2" id="campo_valore2" placeholder="Inserire il secondo valore">
                        <label for="campo_umvalore2">Unità di misura 2</label>
                        <input type="text" class="form-control" name="campo_umvalore2" id="campo_umvalore2" placeholder="Inserire l'unità di misura del secondo valore">
                        <label for="campo_note">Note</label>
                        <textarea class="form-control" name="campo_note" id="campo_note" placeholder="Inserire le note"></textarea>
                        <label for="campo_immagine">Link immagine</label>
                        <input type="text" class="form-control" name="campo_immagine" id="campo_immagine" placeholder="Inserire l'url di un'immagine">
                        <label for="campo_quantita">Quantità minima</label>
                        <input type="number" class="form-control" name="campo_quantita" id="campo_quantita" placeholder="Inserire la quantità minima">
                        <label for="campo_catalogo">Catalogo</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_catalogo" id="campo_catalogo" aria-describedby="basic-addon2">
                                <?php
                                $datiCataloghi = $oggCatal->getCataloghi();
                                if ($datiCataloghi->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il catalogo</option>
                                    <?php
                                    while ($row = $datiCataloghi->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Catalogo'] ?>"><?= $row['catalogo'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un catalogo</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_categoria">Categoria</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_categoria" id="campo_categoria" aria-describedby="basic-addon2">
                                <?php
                                $datiCategoria = $oggCateg->getCategorie();
                                if ($datiCategoria->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il catalogo</option>
                                    <?php
                                    while ($row = $datiCategoria->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Categoria'] ?>"><?= $row['categoria'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un catalogo</option>
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


    <div class="modal fade" id="aggiungiComponente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuovo locale</h5>
                </div>
                <form onsubmit="inviaAggiunta(); return false;">
                    <div class="modal-body">
                        <label for="campo_componente_nuovo">Nome del componente</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="campo_componente_nuovo" id="campo_componente_nuovo" placeholder="Inserire il componente" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_sigla_nuovo">Sigla</label>
                        <input type="text" class="form-control" name="campo_sigla_nuovo" id="campo_sigla_nuovo" placeholder="Inserire la sigla">
                        <label for="campo_valore_nuovo">Valore</label>
                        <input type="number" class="form-control" name="campo_valore_nuovo" id="campo_valore_nuovo" placeholder="Inserire il valore">
                        <label for="campo_umvalore_nuovo">Unità di misura</label>
                        <input type="text" class="form-control" name="campo_umvalore_nuovo" id="campo_umvalore_nuovo" placeholder="Inserire l'unità di misura del primo valore">
                        <label for="campo_valore2_nuovo">Valore 2</label>
                        <input type="number" class="form-control" name="campo_valore2_nuovo" id="campo_valore2_nuovo" placeholder="Inserire il secondo valore">
                        <label for="campo_umvalore2_nuovo">Unità di misura 2</label>
                        <input type="text" class="form-control" name="campo_umvalore2_nuovo" id="campo_umvalore2_nuovo" placeholder="Inserire l'unità di misura del secondo valore">
                        <label for="campo_note_nuovo">Note</label>
                        <textarea class="form-control" name="campo_note_nuovo" id="campo_note_nuovo" placeholder="Inserire le note"></textarea>
                        <label for="campo_immagine_nuovo">Link immagine</label>
                        <input type="text" class="form-control" name="campo_immagine_nuovo" id="campo_immagine_nuovo" placeholder="Inserire l'url di un'immagine">
                        <label for="campo_quantita_nuovo">Quantità minima</label>
                        <input type="number" class="form-control" name="campo_quantita_nuovo" id="campo_quantita_nuovo" placeholder="Inserire la quantità minima">

                        <label for="campo_catalogo_nuovo">Catalogo</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_catalogo_nuovo" id="campo_catalogo_nuovo" aria-describedby="basic-addon2">
                                <?php
                                $datiCataloghi = $oggCatal->getCataloghi();
                                if ($datiCataloghi->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il catalogo</option>
                                    <?php
                                    while ($row = $datiCataloghi->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Catalogo'] ?>"><?= $row['catalogo'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un catalogo</option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-text" id="basic-addon2">Obbligatorio</span>
                        </div>
                        <label for="campo_categoria_nuovo">Categoria</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="campo_categoria_nuovo" id="campo_categoria_nuovo" aria-describedby="basic-addon2">
                                <?php
                                $datiCategoria = $oggCateg->getCategorie();
                                if ($datiCategoria->rowCount() > 0) {
                                ?>
                                    <option value="" selected>Scegliere il catalogo</option>
                                    <?php
                                    while ($row = $datiCategoria->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <option value="<?= $row['ID_Categoria'] ?>"><?= $row['categoria'] ?></option>
                                    <?php
                                    }
                                } else { ?>
                                    <option value="" selected>Prima inserire un catalogo</option>
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
        var idComponente;

        document.getElementById("modificaComponente").addEventListener("keyup", (event) => {
            if (event.keyCode === 13) {
                inviaModifica();
            }
        });

        function inviaID(element) {
            idComponente = element.id;
            console.log(idComponente);
        }

        function inviaModifica() {
            var xhttp = new XMLHttpRequest();

            var componente = document.getElementById('campo_componente').value;
            var sigla = document.getElementById('campo_sigla').value;
            var valore = document.getElementById('campo_valore').value;
            var umvalore = document.getElementById('campo_umvalore').value;
            var valore2 = document.getElementById('campo_valore2').value;
            var umvalore2 = document.getElementById('campo_umvalore2').value;
            var note = document.getElementById('campo_note').value;
            var immagine = document.getElementById('campo_immagine').value;
            var quantita = document.getElementById('campo_quantita').value;
            var catalogo = document.getElementById('campo_catalogo').value;
            var categoria = document.getElementById('campo_categoria').value;


            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (componente && catalogo && categoria) {
                if (globalRegex.test(sigla) && globalRegex.test(umvalore) &&
                    globalRegex.test(umvalore2) && numRegex.test(quantita) &&
                    globalRegex.test(componente)) {

                    const params = {
                        id: idComponente,
                        componente: componente,
                        sigla: sigla,
                        valore: valore,
                        umValore: umvalore,
                        valore2: valore2,
                        umValore2: umvalore2,
                        note: note,
                        immagine: immagine,
                        quantitaMin: quantita,
                        id_categoria: categoria,
                        id_catalogo: catalogo
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    xhttp.open("POST", "/GestionalePHP/api/componenti/modificaComponente.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./comPage.php";
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici e punti. I caratteri speciali accettati nei campi testuali sono - e _.");
                    document.getElementById('campo_componente').value = null;
                    document.getElementById('campo_sigla').value = null;
                    document.getElementById('campo_valore').value = null;
                    document.getElementById('campo_umvalore').value = null;
                    document.getElementById('campo_valore2').value = null;
                    document.getElementById('campo_umvalore2').value = null;
                    document.getElementById('campo_note').value = null;
                    document.getElementById('campo_immagine').value = null;
                    document.getElementById('campo_quantita').value = null;
                    document.getElementById('campo_catalogo').value = null;
                    document.getElementById('campo_categoria').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function inviaAggiunta() {
            var xhttp = new XMLHttpRequest();

            var componente = document.getElementById('campo_componente_nuovo').value;
            var sigla = document.getElementById('campo_sigla_nuovo').value;
            var valore = document.getElementById('campo_valore_nuovo').value;
            var umvalore = document.getElementById('campo_umvalore_nuovo').value;
            var valore2 = document.getElementById('campo_valore2_nuovo').value;
            var umvalore2 = document.getElementById('campo_umvalore2_nuovo').value;
            var note = document.getElementById('campo_note_nuovo').value;
            var immagine = document.getElementById('campo_immagine_nuovo').value;
            var quantita = document.getElementById('campo_quantita_nuovo').value;
            var catalogo = document.getElementById('campo_catalogo_nuovo').value;
            var categoria = document.getElementById('campo_categoria_nuovo').value;

            const globalRegex = new RegExp('^[\-a-zA-Z0-9\_]*$');
            const numRegex = new RegExp('^[0-9\.]*$');

            if (componente && catalogo && categoria) {
                if (globalRegex.test(sigla) && globalRegex.test(umvalore) &&
                    globalRegex.test(umvalore2) && numRegex.test(quantita) &&
                    globalRegex.test(componente)) {

                    const params = {
                        id: idComponente,
                        componente: componente,
                        sigla: sigla,
                        valore: valore,
                        umValore: umvalore,
                        valore2: valore2,
                        umValore2: umvalore2,
                        note: note,
                        immagine: immagine,
                        quantitaMin: quantita,
                        id_categoria: categoria,
                        id_catalogo: catalogo
                    };

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log("Everything is good");
                        }
                    };

                    xhttp.open("POST", "/GestionalePHP/api/componenti/creaComponente.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/json');
                    xhttp.send(JSON.stringify(params));

                    setTimeout(function() {
                        location.href = "./comPage.php";
                    }, 500);
                } else {
                    alert("Inserire solo numeri nei campi numerici e punti. I caratteri speciali accettati nei campi testuali sono - e _.");
                    document.getElementById('campo_componente_nuovo').value = null;
                    document.getElementById('campo_sigla_nuovo').value = null;
                    document.getElementById('campo_valore_nuovo').value = null;
                    document.getElementById('campo_umvalore_nuovo').value = null;
                    document.getElementById('campo_valore2_nuovo').value = null;
                    document.getElementById('campo_umvalore2_nuovo').value = null;
                    document.getElementById('campo_note_nuovo').value = null;
                    document.getElementById('campo_immagine_nuovo').value = null;
                    document.getElementById('campo_quantita_nuovo').value = null;
                    document.getElementById('campo_catalogo_nuovo').value = null;
                    document.getElementById('campo_categoria_nuovo').value = null;
                }
            } else {
                alert("Inserire i valori minimi.");
            }
        }

        function eliminazione(element) {
            var xhttp = new XMLHttpRequest();

            idComponente = element.id;
            console.log(idComponente);

            const params = {
                id: idComponente
            };

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {}
            };

            xhttp.open("POST", "/GestionalePHP/api/componenti/eliminaComponente.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
            setTimeout(function() {
                location.href = "./comPage.php";
            }, 500);
        }

        function ottieniDati() {
            var xhttp = new XMLHttpRequest();

            const params = {
                id: idComponente
            }

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    if (data['risposta']) {
                        document.getElementById('campo_componente').value = data['componente'];
                        document.getElementById('campo_sigla').value = data['sigla'];
                        document.getElementById('campo_valore').value = data['valore'];
                        document.getElementById('campo_umvalore').value = data['umValore'];
                        document.getElementById('campo_valore2').value = data['valore2'];
                        document.getElementById('campo_umvalore2').value = data['umValore2'];
                        document.getElementById('campo_note').value = data['note'];
                        document.getElementById('campo_immagine').value = data['immagine'];
                        document.getElementById('campo_quantita').value = data['quantitaMin'];
                        document.getElementById('campo_catalogo').value = data['id_categoria'];
                        document.getElementById('campo_categoria').value = data['id_catalogo'];
                    } else
                        alert("Problemi con la richiesta. Riprovare.");
                }
            };

            xhttp.open("POST", "/GestionalePHP/api/componenti/ottieniDatiComponente.php", true);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        }

        function visualizza(element) {
            location.href = "/GestionalePHP/pages/componenti/visualizzaComp.php?id=" + element.id;
        }
    </script>
</body>

</html>