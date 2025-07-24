<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>White Noise Gym</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 leading-normal tracking-normal">
    <div class="flex min-h-screen">
        <x-nav/>
        <main class="flex-1">
            {{$slot}}
        </main>
    </div>
</body>
</html>