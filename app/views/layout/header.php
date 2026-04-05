<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = '/Surfing_schoo_challenge';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taghazout Surf Expo</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] . $base ?>/public/css/style.css">
</head>
<body>

<nav>
    <a href="<?= $base ?>/">🏄 Taghazout Surf Expo</a>

    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>

            <span>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></span>

            <?php if ($_SESSION['role'] === 'manager'): ?>
                <a href="<?= $base ?>/students">Students</a>
                <a href="<?= $base ?>/lessons">Lessons</a>
            <?php else: ?>
                <a href="<?= $base ?>/my-lessons">My Lessons</a>
            <?php endif; ?>

            <a href="<?= $base ?>/logout">Logout</a>

        <?php else: ?>
            <a href="<?= $base ?>/login">Login</a>
            <a href="<?= $base ?>/register">Register</a>
        <?php endif; ?>
    </div>
</nav>