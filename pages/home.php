<?php

// Get all tags from the database
$tags = $db->query('SELECT * FROM Tags')->fetchAll();

// Check if a tag filter is applied? Set and NN?
$selectedTag = $_GET['tag'] ?? null;

// Start building the SQL query
$sql = 'SELECT tf.*, GROUP_CONCAT(t.name) AS tags
        FROM Top_Films tf
        LEFT JOIN Film_Tags ft ON tf.film_id = ft.film_id
        LEFT JOIN Tags t ON ft.tag_id = t.tag_id';

// If a tag filter is applied, add a WHERE clause to the SQL query
if ($selectedTag) {
    $sql .= ' WHERE t.name = :selectedTag';
}

// Add a GROUP BY and ORDER BY clause to the SQL query
$sql .= ' GROUP BY tf.film_id ORDER BY tf.ranking DESC';


// Attempt to fetch top-ranked films using $db

    $stmt = $db->prepare($sql);
    if ($selectedTag) {
        $stmt->bindParam(':selectedTag', $selectedTag);
    }
    $stmt->execute();
    $films = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Ranked Films</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-gradient-to-r from-blue-500 to-purple-500 text-white py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold">Top Ranked Films</h1>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Find Your Flavor</h2>
            <div class="flex flex-wrap">
                <a href="details" class="btn bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-2 mb-2">All</a>
                <?php foreach ($tags as $tag): ?>
                    <a href="details?tag=<?= htmlspecialchars($tag['name']) ?>" class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded mr-2 mb-2">
                        <?= htmlspecialchars($tag['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($films)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($films as $film): ?>
                    <a href="details?id=<?= $film['film_id'] ?>" class="block bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        <img src="path/to/placeholder-image.jpg" alt="Film Image" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($film['title']) ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars(substr($film['synopsis'], 0, 100)) ?>...</p>
                            <div class="mb-4">
                                <?php
                                $filmTags = explode(',', $film['tags']);
                                foreach ($filmTags as $filmTag): ?>
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                        <?= htmlspecialchars($filmTag) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 fill-current text-yellow-500 mr-1" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="text-gray-600 font-semibold"><?= htmlspecialchars($film['ranking']) ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No films found in the catalog.</p>
        <?php endif; ?>
    </main>
     <?php include 'includes/footer.php'; ?>
</html>
