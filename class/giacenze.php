<?php
class Giacenze
{
    // Connection
    private $conn;
    // Table
    private $db_table = "giacenze";
    // Columns
    public $id;
    public $posizione;
    public $nomeCassetto;
    public $quantita;
    public $quantitaSpann;
    public $id_armadietto;
    public $id_componente;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE
    public function createGiacenza()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "
                    SET
                        posizione = ?,
                        nomeCassetto = ?,
                        quantita = ?,
                        quantitaSpann = ?,
                        ID_Armadietto = ?,
                        ID_Componente = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->posizione = htmlspecialchars(strip_tags($this->posizione));
        $this->nomeCassetto = htmlspecialchars(strip_tags($this->nomeCassetto));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));
        $this->quantitaSpann = htmlspecialchars(strip_tags($this->quantitaSpann));
        $this->id_armadietto = htmlspecialchars(strip_tags($this->id_armadietto));
        $this->id_componente = htmlspecialchars(strip_tags($this->id_componente));

        $stmt->bindParam(1, $this->posizione);
        $stmt->bindParam(2, $this->nomeCassetto);
        $stmt->bindParam(3, $this->quantita);
        $stmt->bindParam(4, $this->quantitaSpann);
        $stmt->bindParam(5, $this->id_armadietto);
        $stmt->bindParam(6, $this->id_componente);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getGiacenze()
    {
        $sqlQuery = "SELECT
                        ID_Giacenza, posizione, nomeCassetto, quantita, quantitaSpann, ID_Armadietto
                      FROM
                        " . $this->db_table . " WHERE ID_Componente = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id_componente = htmlspecialchars(strip_tags($this->id_componente));
        $stmt->bindParam(1, $this->id_componente);

        $stmt->execute();
        return $stmt;
    }

    public function getSingleGiacenza()
    {
        $sqlQuery = "SELECT
                        posizione, nomeCassetto, quantita, quantitaSpann, ID_Armadietto
                      FROM
                        " . $this->db_table . " WHERE ID_Giacenza = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow;
    }

    public function updateGiacenza()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        posizione = ?,
                        nomeCassetto = ?,
                        quantita = ?,
                        quantitaSpann = ?,
                        ID_Armadietto = ?,
                        ID_Componente = ?
                    WHERE 
                        ID_Giacenza = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->posizione = htmlspecialchars(strip_tags($this->posizione));
        $this->nomeCassetto = htmlspecialchars(strip_tags($this->nomeCassetto));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));
        $this->quantitaSpann = htmlspecialchars(strip_tags($this->quantitaSpann));
        $this->id_armadietto = htmlspecialchars(strip_tags($this->id_armadietto));
        $this->id_componente = htmlspecialchars(strip_tags($this->id_componente));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->posizione);
        $stmt->bindParam(2, $this->nomeCassetto);
        $stmt->bindParam(3, $this->quantita);
        $stmt->bindParam(4, $this->quantitaSpann);
        $stmt->bindParam(5, $this->id_armadietto);
        $stmt->bindParam(6, $this->id_componente);
        $stmt->bindParam(7, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteGiacenza()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Giacenza = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
