<?php


// Check if the 'id' GET parameter is set and is a valid number
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    // SQL statement to delete a film by ID
    $sql = "DELETE FROM Top_Films WHERE film_id = ?";
    $stmt = $db->prepare($sql);

    // Execute the delete command and redirect if successful
    if ($stmt->execute([$id])) {
        header('Location: admin_view_all');
        exit;
    } else {
        // If not successful, display an error message
        echo "Error deleting the film.";
    }
}
?>
