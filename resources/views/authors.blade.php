<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookstore | Authors</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="m-5">
    <h1 class="text-4xl font-bold text-center mb-5">Daftar Penulis</h1>

    @foreach ($authors as $author)
    <ul class="mb-3 p-4 border border-gray-200 rounded bg-amber-100">
        <li class="font-bold text-lg">{{ $author['name'] }}</li>
        <li><span class="font-bold">Bio: </span>{{ $author['bio'] }}</li>
    </ul>
    @endforeach
</body>
</html>