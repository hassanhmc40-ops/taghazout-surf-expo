<?php

require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Student.php';

class LessonController {

    private Lesson  $lessonModel;
    private Student $studentModel;

    // ---------------------------------------------------
    // Constructor — prepare the models
    // ---------------------------------------------------
    public function __construct() {
        $this->lessonModel  = new Lesson();
        $this->studentModel = new Student();
    }

    // ---------------------------------------------------
    // Guard — manager only
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
    // Guard — any logged in user
    // ---------------------------------------------------
    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // ---------------------------------------------------
    // Show all lessons — manager dashboard
    // ---------------------------------------------------
    public function index(): void {
        $this->requireManager();

        $lessons  = $this->lessonModel->findAll();
        $students = $this->studentModel->findAll();

        require_once __DIR__ . '/../views/lessons/index.php';
    }

    // ---------------------------------------------------
    // Show one lesson with enrolled students
    // ---------------------------------------------------
    public function show(int $id): void {
        $this->requireManager();

        $lesson   = $this->lessonModel->findById($id);

        if ($lesson === null) {
            http_response_code(404);
            echo 'Lesson not found';
            return;
        }

        $enrolledStudents = $this->lessonModel->getStudentsForLesson($id);
        $allStudents      = $this->studentModel->findAll();

        require_once __DIR__ . '/../views/lessons/show.php';
    }

    // ---------------------------------------------------
    // Show the create lesson form
    // ---------------------------------------------------
    public function create(): void {
        $this->requireManager();

        require_once __DIR__ . '/../views/lessons/create.php';
    }

    // ---------------------------------------------------
    // Process the create lesson form
    // ---------------------------------------------------
    public function store(): void {
        $this->requireManager();

        $title       = trim($_POST['title']        ?? '');
        $coach       = trim($_POST['coach']        ?? '');
        $scheduledAt = trim($_POST['scheduled_at'] ?? '');

        // Step 1 — validate all fields are filled
        if (empty($title) || empty($coach) || empty($scheduledAt)) {
            $error = 'All fields are required';
            require_once __DIR__ . '/../views/lessons/create.php';
            return;
        }

        // Step 2 — validate date is in the future
        if (strtotime($scheduledAt) <= time()) {
            $error = 'Lesson must be scheduled in the future';
            require_once __DIR__ . '/../views/lessons/create.php';
            return;
        }

        // Step 3 — save to DB and redirect
        $lessonId = $this->lessonModel->create($title, $coach, $scheduledAt);

        header('Location: /lessons/' . $lessonId);
        exit;
    }

    // ---------------------------------------------------
    // Enrol a student into a lesson
    // ---------------------------------------------------
    public function enrol(): void {
        $this->requireManager();

        $studentId = (int) ($_POST['student_id'] ?? 0);
        $lessonId  = (int) ($_POST['lesson_id']  ?? 0);

        if ($studentId === 0 || $lessonId === 0) {
            header('Location: /lessons');
            exit;
        }

        $this->lessonModel->enrolStudent($studentId, $lessonId);

        header('Location: /lessons/' . $lessonId);
        exit;
    }

    // ---------------------------------------------------
    // Surfer dashboard — upcoming lessons
    // ---------------------------------------------------
    public function myLessons(): void {
        $this->requireAuth();

        // Get the student profile using the session user_id
        $student = $this->studentModel->findByUserId($_SESSION['user_id']);

        if ($student === null) {
            echo 'Student profile not found';
            return;
        }

        // Get upcoming lessons for this student
        $lessons = $this->lessonModel->getUpcomingLessonsForStudent($student['id']);

        require_once __DIR__ . '/../views/lessons/my_lessons.php';
    }
}