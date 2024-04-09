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

    public function __construct($db){
        $this->conn = $db;
        
    }

    private function checkPassword() {
        return preg_match($this->passregex, $this->password);
    }

    function create() {
        $checkUserQuery = "SELECT COUNT(*) as cnt FROM " . $this->tabe_name . " WHERE username = ?";
        $checkEmailQuery = "SELECT COUNT(*) as cnt FROM " . $this->tabe_name . " WHERE email = ?";

        $this->username=htmlspecialchars(strip_tags($this->username));
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            http_response_code(406);
            echo "The username cannot be an email";
            exit();
        }
        $stmt = $this->conn->prepare($checkUserQuery);
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
        
        $stmt = $this->conn->prepare($checkEmailQuery);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["cnt"] > 0) {
                http_response_code(406);
                echo "The email " . $this->email . " is already registered";
                exit();
            }
        }
        if (!$this->checkPassword()) {
            http_response_code(406);
            echo "Passwrod needs: ";//TODO change
            exit();
        } 
        $this->password=crypt($this->password, '$1$vaKLBGUrYKqH$');
        $createQuery = "INSERT INTO " . $this->tabe_name . "(username, email, hash)
        values (:username, :email, :hash)";
        $stmt = $this->conn->prepare($createQuery);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':hash', $this->password);//TODO change for env
        return $stmt->execute();
    }

    function getUser($login, $password) {
        $getUserBaseQuery = "SELECT * FROM " . $this->tabe_name;
        
        $query = $getUserBaseQuery;
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $this->email = $login;
            $query = $query . " WHERE email = '" . $this->email . "'";
        } else {
            $this->username = $login;
            $query = $query . " WHERE username = '" . $this->username . "'";   
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
            if ($this->password == crypt($password, '$1$vaKLBGUrYKqH$')) {//TODO change for env
                return true;
            } else {
                echo json_encode(array("message"=> "invalid password"));
            }
        } 
        return false;
    }

    public function update() {
        $getUserBaseQuery = "UPDATE " . $this->tabe_name . " SET username = '$this->username', email='$this->email'";
        if ($this->password) {
            $getUserBaseQuery = $getUserBaseQuery . ", password='$this->password'";
        }
        $getUserBaseQuery = $getUserBaseQuery . " WHERE ID = '$this->id'";
        $stmt = $this->conn->prepare($getUserBaseQuery);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
