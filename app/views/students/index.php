<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container">

    <h1>All Students</h1>

    <?php if (empty($students)): ?>

        <p>No students registered yet.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['country']) ?></td>
                        <td><?= htmlspecialchars($student['level']) ?></td>
                        <td>
                            <a href="/students/<?= (int) $student['id'] ?>">View Profile</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>