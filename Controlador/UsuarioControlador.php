<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buscar un usuario por nombre de usuario
    public function buscarUsuario($username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registrar un nuevo usuario
    public function registrarUsuario($username, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':username' => $username, ':password' => $hash]);
    }
}
?>