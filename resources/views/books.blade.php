<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookstore | Books</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="m-5">
    <h1 class="text-4xl font-bold text-center mb-5">Selamat Datang di Bookstore!</h1>

    @foreach ($books as $book)
        <ul class="mb-3 p-4 border border-gray-200 rounded bg-blue-100">
            <li class="font-bold">{{ $book['title'] }}</li>
            <li>Description: {{ $book['description'] }}</li>
            <li>Price: Rp.{{ $book['price'] }}</li>
            <li>Stock: {{ $book['stock'] }}</li>
        </ul>
    @endforeach
</body>
</html>