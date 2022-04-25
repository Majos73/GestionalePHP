<?php
include("../header.php");
?>
<title>Componenti</title>
</head>

<body>

    <?php
    include("/xampp/htdocs/GestionalePHP/pages/firstNavbar.php");
    include("/xampp/htdocs/GestionalePHP/pages/secondNavbar.php");
    ?>

    <div class="container-table">
        <table id="example" class="display">
            <thead class="dark">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Opzioni</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>

                    </th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>
                        <a id="">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a data-toggle="modal" data-target="#modale">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <a href="#" id="">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST"></form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <script>

    </script>
</body>

</html>