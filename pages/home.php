<?php
// Start PHP session, if it isn't already started and needed for global settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error handling setup for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch available tags
try {
    $tagStmt = $db->prepare('SELECT * FROM Tags');
    $tagStmt->execute();
    $tags = $tagStmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Handle database connection errors gracefully
}

// Check if a tag filter is applied
$selectedTag = $_GET['tag'] ?? null;

// Prepare the SQL query based on the tag filter
$sql = 'SELECT tf.*, GROUP_CONCAT(t.name) AS tags
        FROM Top_Films tf
        LEFT JOIN Film_Tags ft ON tf.film_id = ft.film_id
        LEFT JOIN Tags t ON ft.tag_id = t.tag_id';

if ($selectedTag) {
    $sql .= ' WHERE t.name = :selectedTag';
}

$sql .= ' GROUP BY tf.film_id
          ORDER BY tf.ranking DESC';

// Attempt to fetch top-ranked films using $db
try {
    $stmt = $db->prepare($sql);
    if ($selectedTag) {
        $stmt->bindParam(':selectedTag', $selectedTag);
    }
    $stmt->execute();
    $films = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Handle database connection errors gracefully
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Ranked Films</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-gray-900 text-white py-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">View All Top-Ranked Films</h1>
        </div>
    </header>

    <div class="container mx-auto mt-8">
        <div class="mb-4">
            <h2 class="text-2xl font-bold mb-2">Filter by Tag</h2>
            <div class="flex flex-wrap">
                <a href="home.php" class="btn btn-primary mr-2 mb-2">All</a>
                <?php foreach ($tags as $tag): ?>
                    <a href="home.php?tag=<?= htmlspecialchars($tag['name']) ?>" class="btn btn-secondary mr-2 mb-2">
                        <?= htmlspecialchars($tag['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php if (!empty($films)): ?>
                <?php foreach ($films as $film): ?>
                    <div class="bg-white rounded-lg shadow-md">
                        <img src="path/to/placeholder-image.jpg" alt="Film Image" class="w-full h-48 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($film['title']) ?></h3>
                            <p class="text-gray-700 mb-4"><?= htmlspecialchars($film['synopsis']) ?></p>
                            <div class="mb-4">
                                <span class="font-bold">Tags:</span>
                                <?php
                                $filmTags = explode(',', $film['tags']);
                                foreach ($filmTags as $filmTag): ?>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                        <?= htmlspecialchars($filmTag) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <a href="details?id=<?= $film['film_id'] ?>" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No films found in the catalog.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; // Ensure the path to footer.php is correct ?>
</body>
</html>
