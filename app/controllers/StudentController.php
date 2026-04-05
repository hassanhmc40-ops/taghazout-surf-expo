<?php

require_once __DIR__ . '/../models/Student.php';

class StudentController {

    private Student $studentModel;

    // ---------------------------------------------------
    // Constructor — prepare the model
    // ---------------------------------------------------
    public function __construct() {
        $this->studentModel = new Student();
    }

    // ---------------------------------------------------
    // Guard — block non managers from accessing this controller
    // ---------------------------------------------------
    private function requireManager(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SESSION['role'] !== 'manager') {
            header('Location: /my-lessons');
            exit;
        }
    }

    // ---------------------------------------------------
    // Show all students — manager dashboard
    // ---------------------------------------------------
    public function index(): void {
        $this->requireManager();

        $students = $this->studentModel->findAll();

        require_once __DIR__ . '/../views/students/index.php';
    }

    // ---------------------------------------------------
    // Show one student profile
    // ---------------------------------------------------
    public function show(int $id): void {
        $this->requireManager();

        $student = $this->studentModel->findById($id);

        if ($student === null) {
            http_response_code(404);
            echo 'Student not found';
            return;
        }

        require_once __DIR__ . '/../views/students/show.php';
    }

    // ---------------------------------------------------
    // Update a student level
    // ---------------------------------------------------
    public function updateLevel(): void {
        $this->requireManager();

        $id    = (int) ($_POST['student_id'] ?? 0);
        $level = trim($_POST['level'] ?? '');

        // Validate level — must be one of the three allowed values
        $allowedLevels = ['Beginner', 'Intermediate', 'Advanced'];

        if ($id === 0 || !in_array($level, $allowedLevels)) {
            header('Location: /students');
            exit;
        }

        $this->studentModel->updateLevel($id, $level);

        header('Location: /students/' . $id);
        exit;
    }
}