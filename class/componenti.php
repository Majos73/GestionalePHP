<?php
class Componenti
{
    // Connection
    private $conn;
    // Table
    private $db_table = "componenti";
    // Columns
    public $id;
    public $componente;
    public $sigla;
    public $valore;
    public $umValore;
    public $valore2;
    public $umValore2;
    public $note;
    public $immagine;
    public $quantitaMin;
    public $id_categoria;
    public $id_catalogo;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE
    public function createComponente()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "
                    SET
                        nomeComp = ?,
                        sigla = ?,
                        valore = ?,
                        umValore = ?,
                        valore2 = ?,
                        umValore2 = ?,
                        note = ?,
                        immagine = ?,
                        quantitaMin = ?,
                        ID_Categoria = ?,
                        ID_Catalogo = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->componente = htmlspecialchars(strip_tags($this->componente));
        $this->sigla = htmlspecialchars(strip_tags($this->sigla));
        $this->valore = htmlspecialchars(strip_tags($this->valore));
        $this->umValore = htmlspecialchars(strip_tags($this->umValore));
        $this->valore2 = htmlspecialchars(strip_tags($this->valore2));
        $this->umValore2 = htmlspecialchars(strip_tags($this->umValore2));
        $this->note = htmlspecialchars(strip_tags($this->note));
        $this->immagine = htmlspecialchars(strip_tags($this->immagine));
        $this->quantitaMin = htmlspecialchars(strip_tags($this->quantitaMin));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_catalogo = htmlspecialchars(strip_tags($this->id_catalogo));

        $stmt->bindParam(1, $this->componente);
        $stmt->bindParam(2, $this->sigla);
        $stmt->bindParam(3, $this->valore);
        $stmt->bindParam(4, $this->umValore);
        $stmt->bindParam(5, $this->valore2);
        $stmt->bindParam(6, $this->umValore2);
        $stmt->bindParam(7, $this->note);
        $stmt->bindParam(8, $this->immagine);
        $stmt->bindParam(9, $this->quantitaMin);
        $stmt->bindParam(10, $this->id_categoria);
        $stmt->bindParam(11, $this->id_catalogo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getComponentiPerTable()
    {
        $sqlQuery = "SELECT
                        ID_Componente, nomeComp, sigla, ID_Categoria, ID_Catalogo
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getComponenti()
    {
        $sqlQuery = "SELECT
                        ID_Componente, nomeComp, sigla, valore, umValore, valore2, umValore2, note, immagine, quantitaMin, ID_Categoria, ID_Catalogo
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleComponente()
    {
        $sqlQuery = "SELECT
                        nomeComp, sigla, valore, umValore, valore2, umValore2, note, immagine, quantitaMin, ID_Categoria, ID_Catalogo
                      FROM
                        " . $this->db_table . " WHERE ID_Componente = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow;
    }

    public function updateComponente()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        nomeComp = ?, 
                        sigla = ?,
                        valore = ?, 
                        umValore = ?, 
                        valore2 = ?, 
                        umValore2 = ?, 
                        note = ?, 
                        immagine = ?, 
                        quantitaMin = ?, 
                        ID_Categoria = ?, 
                        ID_Catalogo = ?
                    WHERE 
                        ID_Componente = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->componente = htmlspecialchars(strip_tags($this->componente));
        $this->sigla = htmlspecialchars(strip_tags($this->sigla));
        $this->valore = htmlspecialchars(strip_tags($this->valore));
        $this->umValore = htmlspecialchars(strip_tags($this->umValore));
        $this->valore2 = htmlspecialchars(strip_tags($this->valore2));
        $this->umValore2 = htmlspecialchars(strip_tags($this->umValore2));
        $this->note = htmlspecialchars(strip_tags($this->note));
        $this->immagine = htmlspecialchars(strip_tags($this->immagine));
        $this->quantitaMin = htmlspecialchars(strip_tags($this->quantitaMin));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_catalogo = htmlspecialchars(strip_tags($this->id_catalogo));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->componente);
        $stmt->bindParam(2, $this->sigla);
        $stmt->bindParam(3, $this->valore);
        $stmt->bindParam(4, $this->umValore);
        $stmt->bindParam(5, $this->valore2);
        $stmt->bindParam(6, $this->umValore2);
        $stmt->bindParam(7, $this->note);
        $stmt->bindParam(8, $this->immagine);
        $stmt->bindParam(9, $this->quantitaMin);
        $stmt->bindParam(10, $this->id_categoria);
        $stmt->bindParam(11, $this->id_catalogo);
        $stmt->bindParam(12, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteComponente()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Componente = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
