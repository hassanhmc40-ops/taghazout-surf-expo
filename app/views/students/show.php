<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <a href="/students">← Back to all students</a>

    <h1><?= htmlspecialchars($student['name']) ?></h1>

    <div class="student-info">
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($student['country']) ?></p>
        <p><strong>Current Level:</strong> <?= htmlspecialchars($student['level']) ?></p>
    </div>

    <h2>Update Level</h2>

    <form action="/students/update-level" method="POST">

        <input type="hidden" name="student_id" value="<?= (int) $student['id'] ?>">

        <div class="form-group">
            <label for="level">New Level</label>
            <select id="level" name="level" required>
                <option value="Beginner"
                    <?= $student['level'] === 'Beginner'     ? 'selected' : '' ?>>
                    Beginner
                </option>
                <option value="Intermediate"
                    <?= $student['level'] === 'Intermediate' ? 'selected' : '' ?>>
                    Intermediate
                </option>
                <option value="Advanced"
                    <?= $student['level'] === 'Advanced'     ? 'selected' : '' ?>>
                    Advanced
                </option>
            </select>
        </div>

        <button type="submit">Update Level</button>

    </form>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>