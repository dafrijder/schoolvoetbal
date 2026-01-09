<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>schoolvoetbal</title>
</head>
<body>
    <header>
        <x-navbar />
    </header>
    <main>
        {{ $slot }}
    </main>
    <footer>
    </footer>
</body>
</html>
