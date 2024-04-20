<?php
// Include the database connection file
require_once '../includes/db.php';

// Initialize the database connection
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// Prepare a statement to select all films
$stmt = $db->prepare('SELECT * FROM Top_Films');
$stmt->execute();
$films = $stmt->fetchAll();

// Include the admin header partial
include '../includes/admin_header.php'; // Ensure this file exists and contains the starting HTML tags
?>

<div class="admin-container">
    <h1>Admin Dashboard - View All Films</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Director</th>
                <th>Year</th>
                <th>Ranking</th>
                <th>Awards</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film): ?>
            <tr>
                <td><?= htmlspecialchars($film['title']) ?></td>
                <td><?= htmlspecialchars($film['director']) ?></td>
                <td><?= htmlspecialchars($film['release_year']) ?></td>
                <td><?= htmlspecialchars($film['ranking']) ?></td>
                <td><?= htmlspecialchars($film['awards']) ?></td>
                <td>
                    <a href="edit_film.php?id=<?= $film['film_id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_film.php?id=<?= $film['film_id'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// Include the admin footer partial
include '../includes/admin_footer.php'; // Ensure this file exists and contains the ending HTML tags
?>
