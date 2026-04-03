<?php

require_once __DIR__ . '/Database.php';

class Student {

    private PDO $db;

    // ---------------------------------------------------
    // Constructor — get the database connection
    // ---------------------------------------------------
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // ---------------------------------------------------
    // Create a new student profile
    // Called right after User->create() during registration
    // ---------------------------------------------------
    public function create(int $userId, string $country, string $level): void {
        $stmt = $this->db->prepare('
            INSERT INTO students (user_id, country, level)
            VALUES (:user_id, :country, :level)
        ');

        $stmt->execute([
            ':user_id'  => $userId,
            ':country'  => $country,
            ':level'    => $level
        ]);
    }

    // ---------------------------------------------------
    // Get all students with their user info
    // Called by manager dashboard
    // ---------------------------------------------------
    public function findAll(): array {
        $stmt = $this->db->prepare('
            SELECT students.id, students.country, students.level,
                   users.name, users.email
            FROM students
            JOIN users ON students.user_id = users.id
            ORDER BY users.name ASC
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ---------------------------------------------------
    // Get one student by their student ID
    // Called when manager opens a student profile
    // ---------------------------------------------------
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('
            SELECT students.id, students.country, students.level,
                   users.name, users.email
            FROM students
            JOIN users ON students.user_id = users.id
            WHERE students.id = :id
        ');

        $stmt->execute([':id' => $id]);
        $student = $stmt->fetch();
        return $student ?: null;
    }

    // ---------------------------------------------------
    // Get student profile by user ID
    // Called using the session user_id
    // ---------------------------------------------------
    public function findByUserId(int $userId): ?array {
        $stmt = $this->db->prepare('
            SELECT students.id, students.country, students.level,
                   users.name, users.email
            FROM students
            JOIN users ON students.user_id = users.id
            WHERE students.user_id = :user_id
        ');

        $stmt->execute([':user_id' => $userId]);
        $student = $stmt->fetch();
        return $student ?: null;
    }

    // ---------------------------------------------------
    // Update a student level
    // Called by manager after a lesson
    // ---------------------------------------------------
    public function updateLevel(int $id, string $level): void {
        $stmt = $this->db->prepare('
            UPDATE students
            SET level = :level
            WHERE id = :id
        ');

        $stmt->execute([
            ':level' => $level,
            ':id'    => $id
        ]);
    }
}