<?php
// Assuming $db is globally available

// Prepare a statement to select all films
try {
    $stmt = $db->prepare('SELECT * FROM Top_Films ORDER BY release_year DESC');
    $stmt->execute();
    $films = $stmt->fetchAll();
} catch (PDOException $e) {
    // Handle database errors gracefully
    error_log("Insert the form data into the database.");
}

// Include the admin header partial
include '../includes/admin_header.php'; // Ensure this file exists and contains the starting HTML tags
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View All Films</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-3xl font-bold mb-4">Admin Dashboard - View All Films</h1>
    <table class="table-auto w-full mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">Director</th>
                <th class="px-4 py-2 text-left">Year</th>
                <th class="px-4 py-2 text-left">Ranking</th>
                <th class="px-4 py-2 text-left">Awards</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film): ?>
            <tr>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['title']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['director']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['release_year']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['ranking']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['awards']) ?></td>
                <td class="border px-4 py-2">
                    <a href="edit_film?id=<?= $film['film_id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_film?id=<?= $film['film_id'] ?>" class="btn btn-danger">Delete</a>
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
</body>
</html>
