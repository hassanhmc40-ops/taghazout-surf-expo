<?php
// 1 Loading the dependency
require_once __DIR__ . '/Database.php';

// 2 the class declaration
class User {
// 3 the private property
    private PDO $db;
// THE CONSTRUCTOR
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
//METHOD
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
// METHOD
    public function create(string $name, string $email, string $password): int {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare('
            INSERT INTO users (name, email, password, role)
            VALUES (:name, :email, :password, :role)
        ');

        $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $hashedPassword,
            ':role'     => 'surfer'
        ]);

        return (int) $this->db->lastInsertId();
    }
//METHOD
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}