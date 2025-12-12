@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bookstore</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Book</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
            <div class="border rounded-lg overflow-hidden shadow-md">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $book->title }}</h2>
                    <p class="text-gray-600 mb-2">by {{ $book->author }}</p>
                    <p class="text-lg font-bold text-blue-600">${{ number_format($book->price, 2) }}</p>
                    <div class="mt-4">
                        <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:underline">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>
@endsection