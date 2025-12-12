
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Bookstore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">BookStore</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('books.index') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Books</a>
                    <a href="{{ route('books.create') }}" class="ml-4 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Book</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</body>
</html>