<?php

// Load config and all classes
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/models/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/models/Lesson.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/StudentController.php';
require_once __DIR__ . '/app/controllers/LessonController.php';

// Get the URL path — strip query string
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove project subfolder from URL if running in localhost subfolder
// Change 'Surfing school challenge' to your actual folder name
$basePath = '/Surfing_schoo_challenge';
$url      = str_replace($basePath, '', $url);

// Remove trailing slash except for root
if ($url !== '/' && str_ends_with($url, '/')) {
    $url = rtrim($url, '/');
}

// Initialize controllers
$auth    = new AuthController();
$student = new StudentController();
$lesson  = new LessonController();

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// ---------------------------------------------------
// THE ROUTER
// ---------------------------------------------------

// AUTH routes
if ($url === '/' || $url === '/login') {
    $method === 'POST' ? $auth->login() : $auth->showLogin();

} elseif ($url === '/register') {
    $method === 'POST' ? $auth->register() : $auth->showRegister();

} elseif ($url === '/logout') {
    $auth->logout();

// STUDENT routes
} elseif ($url === '/students') {
    $student->index();

} elseif (preg_match('#^/students/(\d+)$#', $url, $matches)) {
    $student->show((int) $matches[1]);

} elseif ($url === '/students/update-level') {
    $student->updateLevel();

// LESSON routes
} elseif ($url === '/lessons') {
    $lesson->index();

} elseif ($url === '/lessons/create') {
    $lesson->create();

} elseif ($url === '/lessons/store') {
    $lesson->store();

} elseif ($url === '/lessons/enrol') {
    $lesson->enrol();

} elseif ($url === '/my-lessons') {
    $lesson->myLessons();

} elseif (preg_match('#^/lessons/(\d+)$#', $url, $matches)) {
    $lesson->show((int) $matches[1]);

// 404 — nothing matched
} else {
    http_response_code(404);
    echo '404 — Page not found';
}