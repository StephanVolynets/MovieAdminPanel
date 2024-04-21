<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stephan's Cinematic Showcase</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-bg {
            background: linear-gradient(135deg, #6c63ff, #8a4baf);
        }
    </style>
</head>
<body>
    <header class="header-bg text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold tracking-wide" style="font-family: 'Roboto', sans-serif;">Stephan's Cinematic Showcase</h1>
                    <p class="text-xl mt-2" style="font-family: 'Roboto', sans-serif;">Discover the Best Films of All Time</p>
                <div>
                    <a href="admin_view_all" class="bg-white text-purple-600 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-purple-100 transition duration-300">Admin Login</a>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Filter by Tag</h2>
                <div class="flex flex-wrap">
                    <a href="home" class="bg-white text-purple-600 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-purple-100 transition duration-300 mr-4 mb-4">All</a>
                    <?php foreach ($tags as $tag): ?>
                        <a href="home?tag=<?= htmlspecialchars($tag['name']) ?>" class="bg-white text-purple-600 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-purple-100 transition duration-300 mr-4 mb-4">
                            <?= htmlspecialchars($tag['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </header>
    <!-- Rest of the content goes here -->
</body>
</html>
