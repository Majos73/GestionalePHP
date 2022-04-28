<?php
include("../header.php");
include_once("/xampp/htdocs/GestionalePHP/class/componenti.php");
include_once("/xampp/htdocs/GestionalePHP/class/giacenze.php");
include_once("/xampp/htdocs/GestionalePHP/class/categorie.php");
include_once("/xampp/htdocs/GestionalePHP/class/cataloghi.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggComp = new Componenti($db);
$oggGiac = new Giacenze($db);
$oggCateg = new Categorie($db);
$oggCatal = new Cataloghi($db);

$oggComp->id = $_GET['id'];
$datiComponenti = $oggComp->getSingleComponente();

$oggGiac->id_componente = $_GET['id'];
$oggCateg->id = $datiComponenti['ID_Categoria'];
$oggCatal->id = $datiComponenti['ID_Catalogo'];
?>

<title>Componente <?= $_GET['id'] ?></title>
</head>

<body>
    <?php
    include("../firstNavbar.php");
    ?>
    <nav>
        <button data-toggle="modal" data-target="#aggiungiGiacenza">Aggiungi Giacenza <i class="fa-solid fa-plus"></i></button>
    </nav>
    <?php
    include("../secondNavbar.php");
    ?>

    <div class="container-dati">
        <div class="dati">
            <h3>Componente <?= $datiComponenti['nomeComp'] ?> &nbsp
                <a href="#" data-toggle="modal" data-target="#modalImage">
                    <i class="fa-solid fa-image"></i>
                </a>
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
    </div>


    <div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <img src="<?= $datiComponenti['immagine'] ?>" alt="Immagine Componente <?= $datiComponenti['nomeComp'] ?>">
            </div>
        </div>
    </div>
</body>

</html>