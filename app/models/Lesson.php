<?php

require_once __DIR__ . '/Database.php';

class Lesson {

    private PDO $db;

    // ---------------------------------------------------
    // Constructor — get the database connection
    // ---------------------------------------------------
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // ---------------------------------------------------
    // Get all lessons
    // Called by manager dashboard
    // ---------------------------------------------------
    public function findAll(): array {
        $stmt = $this->db->prepare('
            SELECT lessons.id,
                   lessons.title,
                   lessons.coach,
                   lessons.scheduled_at,
                   COUNT(enrollments.id) AS total_students
            FROM lessons
            LEFT JOIN enrollments ON lessons.id = enrollments.lesson_id
            GROUP BY lessons.id
            ORDER BY lessons.scheduled_at ASC
        ');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ---------------------------------------------------
    // Create a new lesson
    // Called when manager submits the create form
    // ---------------------------------------------------
    public function create(string $title, string $coach, string $scheduledAt): int {
        $stmt = $this->db->prepare('
            INSERT INTO lessons (title, coach, scheduled_at)
            VALUES (:title, :coach, :scheduled_at)
        ');

        $stmt->execute([
            ':title'        => $title,
            ':coach'        => $coach,
            ':scheduled_at' => $scheduledAt
        ]);

        return (int) $this->db->lastInsertId();
    }

    // ---------------------------------------------------
    // Enrol a student into a lesson
    // Called when manager assigns a student to a session
    // ---------------------------------------------------
    public function enrolStudent(int $studentId, int $lessonId): void {
        $stmt = $this->db->prepare('
            INSERT IGNORE INTO enrollments (student_id, lesson_id, payment_status)
            VALUES (:student_id, :lesson_id, :payment_status)
        ');

        $stmt->execute([
            ':student_id'     => $studentId,
            ':lesson_id'      => $lessonId,
            ':payment_status' => 'Pending'
        ]);
    }

    // ---------------------------------------------------
    // Get one lesson with all its enrolled students
    // Called when manager opens a lesson detail page
    // ---------------------------------------------------
    public function getStudentsForLesson(int $lessonId): array {
        $stmt = $this->db->prepare('
            SELECT users.name,
                   users.email,
                   students.level,
                   students.country,
                   enrollments.payment_status,
                   enrollments.student_id
            FROM enrollments
            JOIN students ON enrollments.student_id = students.id
            JOIN users    ON students.user_id = users.id
            WHERE enrollments.lesson_id = :lesson_id
            ORDER BY users.name ASC
        ');

        $stmt->execute([':lesson_id' => $lessonId]);
        return $stmt->fetchAll();
    }

    // ---------------------------------------------------
    // Get one lesson by ID
    // Called when manager opens a lesson detail page
    // ---------------------------------------------------
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('
            SELECT * FROM lessons WHERE id = :id
        ');

        $stmt->execute([':id' => $id]);
        $lesson = $stmt->fetch();
        return $lesson ?: null;
    }

    // ---------------------------------------------------
    // Get upcoming lessons for one specific student
    // Called by surfer dashboard
    // ---------------------------------------------------
    public function getUpcomingLessonsForStudent(int $studentId): array {
        $stmt = $this->db->prepare('
            SELECT lessons.id,
                   lessons.title,
                   lessons.coach,
                   lessons.scheduled_at,
                   enrollments.payment_status
            FROM enrollments
            JOIN lessons ON enrollments.lesson_id = lessons.id
            WHERE enrollments.student_id = :student_id
            AND   lessons.scheduled_at  >= NOW()
            ORDER BY lessons.scheduled_at ASC
        ');

        $stmt->execute([':student_id' => $studentId]);
        return $stmt->fetchAll();
    }
}