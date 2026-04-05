<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <a href="/lessons">← Back to all lessons</a>

    <h1>Create New Lesson</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="/lessons/store" method="POST">

        <div class="form-group">
            <label for="title">Session Title</label>
            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="coach">Coach Name</label>
            <input
                type="text"
                id="coach"
                name="coach"
                value="<?= htmlspecialchars($_POST['coach'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="scheduled_at">Date & Time</label>
            <input
                type="datetime-local"
                id="scheduled_at"
                name="scheduled_at"
                value="<?= htmlspecialchars($_POST['scheduled_at'] ?? '') ?>"
                required
            >
        </div>

        <button type="submit">Create Lesson</button>

    </form>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>