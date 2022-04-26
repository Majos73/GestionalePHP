<?php
class Locali
{
    // Connection
    private $conn;
    // Table
    private $db_table = "locali";
    // Columns
    public $id;
    public $locale;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function controlLocale()
    {
        $sqlQuery = "SELECT
                        locale
                      FROM
                        " . $this->db_table . " WHERE ID_Locale = ?";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dataRow)
            return true;
        return false;
    }


    // CREATE
    public function createLocale()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        locale = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->locale = htmlspecialchars(strip_tags($this->locale));
        $stmt->bindParam(1, $this->locale);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLocali()
    {
        $sqlQuery = "SELECT
                        ID_Locale, locale
                      FROM
                        " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function updateLocale()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        locale = ?
                    WHERE 
                        ID_Locale = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute(array($this->locale, $this->id))) {
            return true;
        }
        return false;
    }

    function deleteLocale()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ID_Locale = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function getUsers()
    {
        $sqlQuery = "SELECT nome, cognome, liv FROM " . $this->db_table . " WHERE mail=?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute(array($this->mail));
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return array(0 => $dataRow['nome'], 1 => $dataRow['cognome'], 2 => $dataRow['liv']);
    }


    //Funzioni base da modificare

    // READ single
    public function getSingleLocale()
    {
        $sqlQuery = "SELECT
                        locale
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       ID_Locale = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow['locale'];
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
