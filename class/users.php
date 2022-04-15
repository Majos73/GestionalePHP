<?php
class User
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
    public function getControlUser()
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
            $this->createUser();
            return 1;
        }
        return $dataRow['liv'];
    }

    // CREATE
    public function createUser()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        nome = ?, 
                        cognome = ?,
                        mail = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));

        if ($stmt->execute(array($this->nome, $this->cognome, $this->mail))) {
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

    //Funzioni base da modificare



    public function getUsers()
    {
        $sqlQuery = "SELECT id, email, age, designation, created FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
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
