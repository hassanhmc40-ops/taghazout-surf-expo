<?php
// Start session at the top so every page has access to $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taghazout Surf Expo</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<nav>
    <a href="/">Taghazout Surf Expo</a>

    <?php if (isset($_SESSION['user_id'])): ?>

        <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>

        <?php if ($_SESSION['role'] === 'manager'): ?>
            <a href="/students">Students</a>
            <a href="/lessons">Lessons</a>
        <?php else: ?>
            <a href="/my-lessons">My Lessons</a>
        <?php endif; ?>

        <a href="/logout">Logout</a>

    <?php else: ?>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    <?php endif; ?>
</nav>