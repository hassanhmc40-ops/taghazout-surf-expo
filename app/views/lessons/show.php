<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <a href="/lessons">← Back to all lessons</a>

    <h1><?= htmlspecialchars($lesson['title']) ?></h1>

    <div class="lesson-info">
        <p><strong>Coach:</strong> <?= htmlspecialchars($lesson['coach']) ?></p>
        <p><strong>Date & Time:</strong> <?= htmlspecialchars($lesson['scheduled_at']) ?></p>
    </div>

    <h2>Enrolled Students</h2>

    <?php if (empty($enrolledStudents)): ?>
        <p>No students enrolled yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Country</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolledStudents as $enrolled): ?>
                    <tr>
                        <td><?= htmlspecialchars($enrolled['name']) ?></td>
                        <td><?= htmlspecialchars($enrolled['email']) ?></td>
                        <td><?= htmlspecialchars($enrolled['level']) ?></td>
                        <td><?= htmlspecialchars($enrolled['country']) ?></td>
                        <td><?= htmlspecialchars($enrolled['payment_status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Enrol a Student</h2>

    <?php if (empty($allStudents)): ?>
        <p>No students available to enrol.</p>
    <?php else: ?>
        <form action="/lessons/enrol" method="POST">

            <input type="hidden" name="lesson_id"
                value="<?= (int) $lesson['id'] ?>">

            <div class="form-group">
                <label for="student_id">Select Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Choose a student</option>
                    <?php foreach ($allStudents as $student): ?>
                        <option value="<?= (int) $student['id'] ?>">
                            <?= htmlspecialchars($student['name']) ?>
                            (<?= htmlspecialchars($student['level']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Enrol Student</button>

        </form>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>