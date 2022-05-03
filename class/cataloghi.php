<?php
class Cataloghi
{
    // Connection
    private $conn;
    // Table
    private $db_table = "cataloghi";
    // Columns
    public $id;
    public $catalogo;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE
    public function createCatalogo()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        catalogo = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->catalogo = htmlspecialchars(strip_tags($this->catalogo));
        $stmt->bindParam(1, $this->catalogo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCataloghi()
    {
        $sqlQuery = "SELECT
                        ID_Catalogo, catalogo
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function updateCatalogo()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        catalogo = ?
                    WHERE 
                        ID_Catalogo = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->catalogo = htmlspecialchars(strip_tags($this->catalogo));

        $stmt->bindParam(1, $this->catalogo);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteCatalogo()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Catalogo = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSingleCatalogo()
    {
        $sqlQuery = "SELECT
                        catalogo
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       ID_Catalogo = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow['catalogo'];
    }
}
