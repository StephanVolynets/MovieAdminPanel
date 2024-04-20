<?php
// Assuming home.php is in the 'pages' directory, we need to go up one directory to include db.php
require_once '../includes/db.php';

// Initialize the database connection
$pdo = init_sqlite_db('../db/site.sqlite', '../db/init.sql');

// Verify that the PDO object has been created
if ($pdo) {
    echo "PDO object created successfully.";
} else {
    echo "Failed to create PDO object.";
}

// Test a simple query
try {
    $stmt = $pdo->query('SELECT * FROM Top_Films');
    $films = $stmt->fetchAll();
    echo "<pre>";
    print_r($films);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
