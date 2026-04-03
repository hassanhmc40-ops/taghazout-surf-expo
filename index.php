<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/models/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Student.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

// Get the URL path
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$url = str_replace('/Surfing_schoo_challenge','', $url);

$auth = new AuthController();

// Route the request to the right method
match($url) {
    '/'          => $auth->showLogin(),
    '/login'     => $_SERVER['REQUEST_METHOD'] === 'POST' ? $auth->login() : $auth->showLogin(),
    '/register'  => $_SERVER['REQUEST_METHOD'] === 'POST' ? $auth->register() : $auth->showRegister(),
    '/logout'    => $auth->logout(),
    '/logout'    => $auth->logout(),
    default      => http_response_code(404)
};