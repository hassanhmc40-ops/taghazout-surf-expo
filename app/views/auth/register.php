<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <h1>Create your surfer profile</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= $baseUrl ?>/register" method="POST">

        <div class="form-group">
            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                required
            >
        </div>

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

        <div class="form-group">
            <label for="country">Country</label>
            <input
                type="text"
                id="country"
                name="country"
                value="<?= htmlspecialchars($_POST['country'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="level">Level</label>
            <select id="level" name="level" required>
                <option value="">Select your level</option>
                <option value="Beginner"     <?= ($_POST['level'] ?? '') === 'Beginner'     ? 'selected' : '' ?>>Beginner</option>
                <option value="Intermediate" <?= ($_POST['level'] ?? '') === 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
                <option value="Advanced"     <?= ($_POST['level'] ?? '') === 'Advanced'     ? 'selected' : '' ?>>Advanced</option>
            </select>
        </div>

        <button type="submit">Create Profile</button>

    </form>

    <p>Already have an account? <a href="<?= $baseUrl ?>/login">Login here</a></p>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>