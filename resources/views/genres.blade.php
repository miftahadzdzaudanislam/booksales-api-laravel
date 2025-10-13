<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookstore | Genres</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="m-3">
    <h1 class="text-4xl font-bold text-center mb-5">Daftar Genre</h1>
    
    @foreach ($genres as $genre)
    <ul class="mb-3 p-4 border border-gray-200 rounded bg-rose-100">
        <li class="font-bold text-lg">{{ $genre['name'] }}</li>
        <li><span class="font-bold">Description: </span>{{ $genre['description'] }}</li>
    </ul>
    @endforeach
</body>
</html>