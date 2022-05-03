<?php
class Admin
{
    // Connection
    private $conn;
    // Table
    private $db_table = "users";
    // Columns
    public $id;
    public $nome;
    public $cognome;
    public $mail;
    public $liv;
    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function controlMail(){
        $sqlQuery = "SELECT
                        liv
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       mail = ?
                    LIMIT 0,1";
                    
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->mail);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dataRow['liv'];
    }

    public function getControlAdmin()
    {
        $sqlQuery = "SELECT
                        ID_User, liv
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       mail = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->mail);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dataRow) {
            $arrayMail = explode("@", $this->mail);
            $arrayMail = explode(".", $arrayMail[0]);
            if ($arrayMail[0] == "ata" || $arrayMail[0] == "prof") {
                $this->cognome = $arrayMail[1];
                $this->nome = $arrayMail[2];
            } else {
                $this->cognome = $arrayMail[0];
                $this->nome = $arrayMail[1];
            }

            $this->controlAdmin();
            $this->createAdmin();
            return array(0 => $this->nome, 1 => $this->cognome, 2 => $this->liv);
        }
        return $this->getUsers();
    }

    public function controlAdmin()
    {
        $sqlQuery = "SELECT
                        ID_User
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       liv = 10
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dataRow)
            $this->liv = 10;
        else
            $this->liv = 1;
    }

    // CREATE
    public function createAdmin()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        nome = ?, 
                        cognome = ?,
                        mail = ?,
                        liv = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));

        if ($stmt->execute(array($this->nome, $this->cognome, $this->mail, $this->liv))) {
            return true;
        }
        return false;
    }

    public function getLiv()
    {
        $sqlQuery = "SELECT
                        liv
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       mail = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->mail);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->liv = $dataRow['liv'];
    }

    //Modifica livello

    public function updateLiv()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        liv = ?
                    WHERE 
                        id = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute(array($this->liv, $this->id))) {
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
