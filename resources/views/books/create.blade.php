<!-- resources/views/books/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Book</h3>
    </div>
    <div class="border-t border-gray-200">
        <form action="{{ route('books.store') }}" method="POST" class="px-4 py-5 sm:p-6">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                    <input type="text" name="author" id="author" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                    <input type="text" name="isbn" id="isbn" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="col-span-6">
                    <label class="block text-sm font-medium text-gray-700">Categories</label>
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label class="ml-2 text-sm text-gray-700">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('books.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection