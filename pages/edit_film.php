<?php
require_once '../includes/db.php';

$film = null;

// Check if the 'id' GET parameter is set
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current film data
    $stmt = $pdo->prepare('SELECT * FROM Top_Films WHERE film_id = ?');
    $stmt->execute([$id]);
    $film = $stmt->fetch();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and assign POST data to variables
    $title = trim($_POST['title']);
    $director = trim($_POST['director']);
    $year = trim($_POST['year']);
    $ranking = trim($_POST['ranking']);
    $awards = trim($_POST['awards']);

    // Update the film data in the database
    $stmt = $pdo->prepare('UPDATE Top_Films SET title = ?, director = ?, release_year = ?, ranking = ?, awards = ? WHERE film_id = ?');
    $stmt->execute([$title, $director, $year, $ranking, $awards, $id]);

    // Redirect after update
    header('Location: admin_view_all.php');
    exit;
}

include '../includes/admin_header.php';
?>

<div class="edit-film-form">
    <h1>Edit Film</h1>
    <form action="edit_film.php?id=<?= $id ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required value="<?= htmlspecialchars($film['title'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="director">Director</label>
            <input type="text" class="form-control" id="director" name="director" required value="<?= htmlspecialchars($film['director'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <input type="number" class="form-control" id="year" name="year" required value="<?= htmlspecialchars($film['release_year'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="ranking">Ranking</label>
            <input type="number" step="0.1" class="form-control" id="ranking" name="ranking" required value="<?= htmlspecialchars($film['ranking'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="awards">Awards</label>
            <input type="text" class="form-control" id="awards" name="awards" required value="<?= htmlspecialchars($film['awards'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
