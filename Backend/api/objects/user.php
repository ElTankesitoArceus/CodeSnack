<?php
class User {
    private $conn;
    private $tabe_name = "users";
    public $id;
    public $username;
    public $password;
    public $email;
    public $profile_pic;

    public function __construct($db){
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->tabe_name . "(username, email, hash)
        values (:username, :email, :hash)";
        $stmt = $this->conn->prepare($query);

        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=crypt($this->password, "test");

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':hash', $this->password);//TODO change for envl
        return $stmt->execute();
    }
}
