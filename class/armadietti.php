<?php
class Armadietti
{
    // Connection
    private $conn;
    // Table
    private $db_table = "armadietti";
    // Columns
    public $id;
    public $armadietto;
    public $ripiani;
    public $numPorte;
    public $larghezza;
    public $lunghezza;
    public $altezza;
    public $id_locale;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function controlLocale()
    {
        $sqlQuery = "SELECT
                        ID_Armadietto
                      FROM
                        " . $this->db_table . " WHERE ID_Locale = ?";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id_locale);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dataRow)
            return true;
        return false;
    }

    // CREATE
    public function createArmadietto()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . "
                    SET
                        nomeArmadietto = ?,
                        ripiani = ?,
                        numPorte = ?,
                        larghezza = ?,
                        lunghezza = ?,
                        altezza = ?,
                        ID_Locale = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->armadietto = htmlspecialchars(strip_tags($this->armadietto));
        $this->ripiani = htmlspecialchars(strip_tags($this->ripiani));
        $this->numPorte = htmlspecialchars(strip_tags($this->numPorte));
        $this->larghezza = htmlspecialchars(strip_tags($this->larghezza));
        $this->lunghezza = htmlspecialchars(strip_tags($this->lunghezza));
        $this->altezza = htmlspecialchars(strip_tags($this->altezza));
        $this->id_locale = htmlspecialchars(strip_tags($this->id_locale));

        $stmt->bindParam(1, $this->armadietto);
        $stmt->bindParam(2, $this->ripiani);
        $stmt->bindParam(3, $this->numPorte);
        $stmt->bindParam(4, $this->larghezza);
        $stmt->bindParam(5, $this->lunghezza);
        $stmt->bindParam(6, $this->altezza);
        $stmt->bindParam(7, $this->id_locale);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getArmadietti()
    {
        $sqlQuery = "SELECT
                        ID_Armadietto, nomeArmadietto, ripiani, numPorte, larghezza, lunghezza, altezza, ID_Locale
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleArmadietto()
    {
        $sqlQuery = "SELECT
                        nomeArmadietto, ripiani, numPorte, larghezza, lunghezza, altezza, ID_Locale
                      FROM
                        " . $this->db_table . " WHERE ID_Armadietto = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow;
    }

    public function updateArmadietto()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        nomeArmadietto = ?,
                        ripiani = ?, 
                        numPorte = ?,
                        larghezza = ?,
                        lunghezza = ?,
                        altezza = ?,
                        ID_Locale = ?
                    WHERE 
                        ID_Armadietto = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->armadietto = htmlspecialchars(strip_tags($this->armadietto));
        $this->ripiani = htmlspecialchars(strip_tags($this->ripiani));
        $this->numPorte = htmlspecialchars(strip_tags($this->numPorte));
        $this->larghezza = htmlspecialchars(strip_tags($this->larghezza));
        $this->lunghezza = htmlspecialchars(strip_tags($this->lunghezza));
        $this->altezza = htmlspecialchars(strip_tags($this->altezza));
        $this->id_locale = htmlspecialchars(strip_tags($this->id_locale));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->armadietto);
        $stmt->bindParam(2, $this->ripiani);
        $stmt->bindParam(3, $this->numPorte);
        $stmt->bindParam(4, $this->larghezza);
        $stmt->bindParam(5, $this->lunghezza);
        $stmt->bindParam(6, $this->altezza);
        $stmt->bindParam(7, $this->id_locale);
        $stmt->bindParam(8, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteArmadietto()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Armadietto = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }




    //Funzioni base da modificare
    public function getUsers()
    {
        $sqlQuery = "SELECT nome, cognome, liv FROM " . $this->db_table . " WHERE mail=?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute(array($this->mail));
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return array(0 => $dataRow['nome'], 1 => $dataRow['cognome'], 2 => $dataRow['liv']);
    }

    // READ single
    public function getSingleUser()
    {
        $sqlQuery = "SELECT
                        id
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       mail = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->mail);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $dataRow['id'];
    }
    // UPDATE
    public function updateEmployee()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        name = :name, 
                        email = :email, 
                        age = :age, 
                        designation = :designation, 
                        created = :created
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->designation = htmlspecialchars(strip_tags($this->designation));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":designation", $this->designation);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
