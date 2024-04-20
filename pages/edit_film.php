<?php
// Initialize page state (assuming $db is already set up)

// Check if the 'id' GET parameter is set and is a valid number
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current film data
    $stmt = $db->prepare('SELECT * FROM Top_Films WHERE film_id = ?');
    $stmt->execute([$id]);
    $film = $stmt->fetch();

    // Fetch the associated tags for the film using the 'id' parameter
    $stmt = $db->prepare('SELECT t.name
                          FROM Tags t
                          JOIN Film_Tags ft ON t.tag_id = ft.tag_id
                          WHERE ft.film_id = ?');
    $stmt->execute([$id]);
    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // If the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Store form data as variables
        $title = trim($_POST['title']);
        $director = trim($_POST['director']);
        $year = $_POST['year'];
        $ranking = $_POST['ranking'];
        $awards = trim($_POST['awards']);

        // Assume form is valid
        $form_valid = true;

        // Validate each piece of form data
        if (empty($title)) {
            $form_valid = false;
        }
        if (empty($director)) {
            $form_valid = false;
        }
        if (empty($year) || !is_numeric($year)) {
            $form_valid = false;
        }
        if (empty($ranking) || !is_numeric($ranking)) {
            $form_valid = false;
        }

        // If form data is valid
        if ($form_valid) {
            // Update the film data in the database
            $stmt = $db->prepare('UPDATE Top_Films SET title = ?, director = ?, release_year = ?, ranking = ?, awards = ? WHERE film_id = ?');
            $stmt->execute([$title, $director, $year, $ranking, $awards, $id]);

            // Redirect to the admin view all page
            header('Location: admin_view_all');
            exit;
        }
    }
} else {
    // If 'id' parameter is invalid or not set, redirect to the admin view all page
    header('Location: admin_view_all.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film - <?= htmlspecialchars($film['title']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Edit Film</h1>
        <form action="edit_film?id=<?= $id ?>" method="post" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="title" class="block mb-2 font-bold text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($film['title'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label for="director" class="block mb-2 font-bold text-gray-700">Director</label>
                <input type="text" id="director" name="director" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($film['director'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label for="year" class="block mb-2 font-bold text-gray-700">Year</label>
                <input type="number" id="year" name="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($film['release_year'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label for="ranking" class="block mb-2 font-bold text-gray-700">Ranking</label>
                <input type="number" step="0.1" id="ranking" name="ranking" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($film['ranking'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label for="awards" class="block mb-2 font-bold text-gray-700">Awards</label>
                <input type="text" id="awards" name="awards" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($film['awards'] ?? '') ?>" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700">Tags</label>
                <div class="flex flex-wrap">
                    <?php foreach ($tags as $tag): ?>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700">Placeholder Image</label>
                <img src="path/to/placeholder-image.jpg" alt="Placeholder Image" class="w-full h-auto rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">Save Changes</button>
        </form>
    </div>
</body>
</html>
