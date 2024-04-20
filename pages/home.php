<?php
// Start PHP session, if it isn't already started and needed for global settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error handling setup for development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Attempt to fetch top-ranked films using $db
try {
    $stmt = $db->prepare('SELECT * FROM Top_Films ORDER BY ranking DESC');
    $stmt->execute();
    $films = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());  // Handle database connection errors gracefully
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Ranked Films</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css">  <!-- Update path to your CSS file -->
</head>
<body>
    <header>
        <h1>View All Top-Ranked Films</h1>
    </header>

    <div class="container mt-4">
        <div class="row">
            <?php if (!empty($films)): ?>
                <?php foreach ($films as $film): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="path/to/placeholder-image.jpg" class="card-img-top" alt="Film Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($film['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($film['synopsis']) ?></p>
                                <a href="details.php?id=<?= $film['film_id'] ?>" class="btn btn-primary">More Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No films found in the catalog.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php';  // Ensure the path to footer.php is correct ?>
</body>
</html>
