<?php
class Categorie
{
    // Connection
    private $conn;
    // Table
    private $db_table = "categorie";
    // Columns
    public $id;
    public $categoria;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE
    public function createCategoria()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        categoria = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $stmt->bindParam(1, $this->categoria);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCategorie()
    {
        $sqlQuery = "SELECT
                        ID_Categoria, categoria
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function updateCategoria()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        categoria = ?
                    WHERE 
                        ID_Categoria = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));

        $stmt->bindParam(1, $this->categoria);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteCategoria()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Categoria = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSingleCategoria()
    {
        $sqlQuery = "SELECT
                        categoria
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       ID_Categoria = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow['categoria'];
    }
}
