<?php
class User {
    private $conn;
    private $tabe_name = "users";
    public $id;
    public $username;
    public $password;
    public $email;
    public $profile_pic;

    private $passregex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-@!$%*?&._])[A-Za-z\d\-@!$%*?&._]{8,30}$/";
    private $checkUserQuery = "SELECT COUNT(*) as cnt FROM " . $this->tabe_name . " WHERE username = ?";
    private $checkEmailQuery = "SELECT COUNT(*) as cnt FROM " . $this->tabe_name . " WHERE email = ?";
    private $getUserBaseQuery = "SELECT * FROM " . $this->tabe_name;

    public function __construct($db){
        $this->conn = $db;
    }

    function create() {
        $this->username=htmlspecialchars(strip_tags($this->username));
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            http_response_code(406);
            echo "The username cannot be an email";
            exit();
        }
        $stmt = $this->conn->prepare($this->checkUserQuery);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["cnt"] > 0) {
                http_response_code(406);
                echo "The username " . $this->username . " already exists";
                exit();
            }
        }
        $this->email=htmlspecialchars(strip_tags($this->email));
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(406);
            echo "Invalid email: " . $this->email;
            exit();
        }
        
        $stmt = $this->conn->prepare($this->checkEmailQuery);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["cnt"] > 0) {
                http_response_code(406);
                echo "The email " . $this->email . " is already registered";
                exit();
            }
        }
        if (!preg_match($this->passregex, $this->password)) {
            http_response_code(406);
            echo "Passwrod needs: ";//TODO change
            exit();
        } 
        $this->password=crypt($this->password, "test");

        $createQuery = "INSERT INTO " . $this->tabe_name . "(username, email, hash)
        values (:username, :email, :hash)";
        $stmt = $this->conn->prepare($createQuery);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':hash', $this->password);//TODO change for envl
        return $stmt->execute();
    }

    function getUser($login, $password) {
        $query = $this->getUserBaseQuery;
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $this->email = $login;
            $query += " WHERE email = '" . $this->email . "'";
        } else {
            $this->username = $login;
            $query += " WHERE username = '" . $this->email . "'";
        }
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->password = $row['hash'];
            if ($this->password != crypt($this->password, "test")) {

            }
        } else {
            return false;
        }
    }
}
