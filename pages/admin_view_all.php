<?php

// Fetch total number of films
$stmt = $db->query('SELECT COUNT(*) AS total_films FROM Top_Films');
$total_films = $stmt->fetch()['total_films'];

// Fetch total number of distinct directors
$stmt = $db->query('SELECT COUNT(DISTINCT director) AS total_directors FROM Top_Films');
$total_directors = $stmt->fetch()['total_directors'];

// Fetch total number of awards
$stmt = $db->query('SELECT SUM(award_count) AS total_awards FROM Top_Films');
$total_awards = $stmt->fetch()['total_awards'];

// Fetch average rating
$stmt = $db->query('SELECT AVG(ranking) AS average_rating FROM Top_Films');
$average_rating = $stmt->fetch()['average_rating'];

// Fetch all films
$stmt = $db->query('SELECT * FROM Top_Films ORDER BY release_year DESC');
$films = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Top Films</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #6366F1, #4F46E5);
        }
        .bg-primary {
            background-color: #6366F1;
        }
        .text-primary {
            color: #6366F1;
        }
        th, td {
            text-align: center;
        }
        tbody tr:hover {
            background-color: #F3F4F6;
        }
        .btn-primary {
            background-color: #6366F1;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4F46E5;
        }
        .btn-danger {
            background-color: #EF4444;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #DC2626;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .h2 {
            font:
        }
    </style>
</head>
<body class="bg-gray-100">
   <?php include 'includes/admin_header.php'; ?>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-white rounded-2xl p-6 shadow-3d flex items-center">
        <div class="bg-blue-500 text-white rounded-full p-3 mr-4">
            <i class="fas fa-film fa-2x"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold mb-2" style="font-family: 'Roboto', sans-serif;">Total Films</h2>
            <p class="text-4xl font-bold text-primary" style="font-family: 'Roboto', sans-serif;"><?= $total_films ?></p>
        </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-3d flex items-center">
            <div class="bg-green-500 text-white rounded-full p-3 mr-4">
                <i class="fas fa-user-tie fa-2x"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2" style="font-family: 'Roboto', sans-serif;">Directors</h2>
                <p class="text-4xl font-bold text-primary" style="font-family: 'Roboto', sans-serif;"><?= $total_directors ?></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-3d flex items-center">
            <div class="bg-yellow-500 text-white rounded-full p-3 mr-4">
                <i class="fas fa-award fa-2x"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2" style="font-family: 'Roboto', sans-serif;">Total Awards</h2>
                <p class="text-4xl font-bold text-primary" style="font-family: 'Roboto', sans-serif;"><?= $total_awards ?></p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-3d flex items-center">
            <div class="bg-red-500 text-white rounded-full p-3 mr-4">
                <i class="fas fa-star fa-2x"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-2" style="font-family: 'Roboto', sans-serif;">Average Rating</h2>
                <p class="text-4xl font-bold text-primary" style="font-family: 'Roboto', sans-serif;"><?= number_format($average_rating, 1) ?></p>
            </div>
        </div>
</div>

<h2 class="text-3xl font-bold my-6 text-center" style="font-family: 'Roboto', sans-serif;">Films</h2>
<div class="bg-white rounded-2xl shadow-3d overflow-hidden">
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gradient-primary text-white">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Director</th>
                <th class="px-4 py-2">Year</th>
                <th class="px-4 py-2">Ranking</th>
                <th class="px-4 py-2">Awards</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film): ?>
            <tr>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['title']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['director']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['release_year']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['ranking']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($film['award_count']) ?></td>
                <td class="border px-4 py-2 flex justify-center space-x-2">
                    <a href="edit_film?id=<?= $film['film_id'] ?>" class="btn-primary py-1 px-2 rounded">Edit</a>
                    <a href="delete_film?id=<?= $film['film_id'] ?>" class="btn-danger py-1 px-2 rounded">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/admin_footer.php'; ?>
