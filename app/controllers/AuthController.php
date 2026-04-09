<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Student.php';

class AuthController {

    private User $userModel;
    private Student $studentModel;

    public string $baseUrl;

    // ---------------------------------------------------
    // Constructor — prepare the models we need
    // ---------------------------------------------------
    public function __construct() {
        $this->userModel    = new User();
        $this->studentModel = new Student();
        $this->baseUrl      = 'http://localhost/Surfing_schoo_challenge';
    }

    // ---------------------------------------------------
    // Show the login form
    // ---------------------------------------------------
    public function showLogin(): void {
        $baseUrl = $this->baseUrl; // for use in the view
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // ---------------------------------------------------
    // Process the login form when submitted
    // ---------------------------------------------------
    public function login(): void {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Step 1 — are fields empty?
        if (empty($email) || empty($password)) {
            $error = 'All fields are required';
            $bashUrl = $this->baseUrl; // for use in the view
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        // Step 2 — does this email exist?
        $user = $this->userModel->findByEmail($email);
        if ($user === null) {
            $error = 'Email not found';
            $bashUrl = $this->baseUrl; // for use in the view
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        // Step 3 — does the password match?
        if (!password_verify($password, $user['password'])) {
            $error = 'Wrong password';
            $bashUrl = $this->baseUrl; // for use in the view
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        // Step 4 — everything is correct, start the session
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];

        // Step 5 — redirect based on role
        if ($user['role'] === 'manager') {
            header('Location: ' . $this->baseUrl . '/students');
        } else {
            header('Location: ' . $this->baseUrl . '/my-lessons');
        }
        exit;
    }

    // ---------------------------------------------------
    // Show the register form
    // ---------------------------------------------------
    public function showRegister(): void {
        $baseUrl = $this->baseUrl; // for use in the view    
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // ---------------------------------------------------
    // Process the register form when submitted
    // ---------------------------------------------------
    public function register(): void {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $country  = trim($_POST['country'] ?? '');
        $level    = trim($_POST['level'] ?? '');

        // Step 1 — are all fields filled?
        if (empty($name) || empty($email) || empty($password) || empty($country) || empty($level)) {
            $error = 'All fields are required';
            $baseUrl = $this->baseUrl; // for use in the view
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

        // Step 2 — is the email already taken?
        if ($this->userModel->findByEmail($email) !== null) {
            $error = 'Email already exists';
            $baseUrl = $this->baseUrl; // for use in the view
            require_once __DIR__ . '/../views/auth/register.php';
            return;
        }

        // Step 3 — create the user, get the new ID
        $userId = $this->userModel->create($name, $email, $password);

        // Step 4 — create the student profile using that ID
        $this->studentModel->create($userId, $country, $level);

        // Step 5 — redirect to login
        header('Location: ' . $this->baseUrl . '/login');
        exit;
    }

    // ---------------------------------------------------
    // Logout — destroy session and redirect
    // ---------------------------------------------------
    public function logout(): void {
        session_start();
        session_destroy();
        header('Location: ' . $this->baseUrl . '/login');
        exit;
    }
}