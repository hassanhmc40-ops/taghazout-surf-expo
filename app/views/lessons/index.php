<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <div class="page-header">
        <h1>All Lessons</h1>
        <a href="/lessons/create">+ Create New Lesson</a>
    </div>

    <?php if (empty($lessons)): ?>

        <p>No lessons scheduled yet.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Coach</th>
                    <th>Date & Time</th>
                    <th>Students</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?= htmlspecialchars($lesson['title']) ?></td>
                        <td><?= htmlspecialchars($lesson['coach']) ?></td>
                        <td><?= htmlspecialchars($lesson['scheduled_at']) ?></td>
                        <td><?= (int) $lesson['total_students'] ?></td>
                        <td>
                            <a href="/lessons/<?= (int) $lesson['id'] ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>