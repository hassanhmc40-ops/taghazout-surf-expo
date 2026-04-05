<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <h1>My Upcoming Lessons</h1>

    <div class="student-info">
        <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
        <p><strong>Level:</strong> <?= htmlspecialchars($student['level']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($student['country']) ?></p>
    </div>

    <?php if (empty($lessons)): ?>

        <p>You have no upcoming lessons.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Coach</th>
                    <th>Date & Time</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?= htmlspecialchars($lesson['title']) ?></td>
                        <td><?= htmlspecialchars($lesson['coach']) ?></td>
                        <td><?= htmlspecialchars($lesson['scheduled_at']) ?></td>
                        <td>
                            <span class="status <?= $lesson['payment_status'] === 'Paid' ? 'paid' : 'pending' ?>">
                                <?= htmlspecialchars($lesson['payment_status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>


