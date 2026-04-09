<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <h1>Login</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= $baseUrl ?>/login" method="POST">

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <button type="submit">Login</button>

    </form>

    <p>No account? <a href="<?= $baseUrl ?>/register">Register here</a></p>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>