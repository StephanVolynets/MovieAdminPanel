<?php
// Start PHP session, if it isn't already started and needed for global settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error handling setup for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the 'id' GET parameter is set and is a valid number
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the film details using the 'id' parameter
    try {
        $stmt = $db->prepare('SELECT * FROM Top_Films WHERE film_id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $film = $stmt->fetch();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage()); // Handle database connection errors gracefully
    }

    // Fetch the associated tags for the film using the 'id' parameter
    try {
        $stmt = $db->prepare('SELECT t.name
                              FROM Tags t
                              JOIN Film_Tags ft ON t.tag_id = ft.tag_id
                              WHERE ft.film_id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage()); // Handle database connection errors gracefully
    }
} else {
    // If 'id' parameter is invalid or not set, redirect to the home page
    header('Location: home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($film['title']) ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-gray-900 text-white py-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($film['title']) ?></h1>
        </div>
    </header>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <img src="path/to/placeholder-image.jpg" alt="Film Image" class="w-full h-auto rounded-lg shadow-md">
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-4">Details</h2>
                <p class="mb-4"><strong>Director:</strong> <?= htmlspecialchars($film['director']) ?></p>
                <p class="mb-4"><strong>Release Year:</strong> <?= htmlspecialchars($film['release_year']) ?></p>
                <p class="mb-4"><strong>Ranking:</strong> <?= htmlspecialchars($film['ranking']) ?></p>
                <p class="mb-4"><strong>Awards:</strong> <?= htmlspecialchars($film['awards']) ?></p>
                <div class="mb-4">
                    <h3 class="text-xl font-bold mb-2">Tags</h3>
                    <?php foreach ($tags as $tag): ?>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                            <?= htmlspecialchars($tag) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <p class="mb-4"><strong>Synopsis:</strong></p>
                <p><?= htmlspecialchars($film['synopsis']) ?></p>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; // Ensure the path to footer.php is correct ?>
</body>
</html>
