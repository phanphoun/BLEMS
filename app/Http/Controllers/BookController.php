<?php

// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('categories')->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'nullable|string|unique:books,slug',
        'description' => 'required|string',
        'isbn' => 'nullable|string|unique:books,isbn',
        'author' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'cover_image' => 'nullable|image|max:2048',
        'published_date' => 'nullable|date',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id',
    ]);

    // Generate slug if not provided
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']);
    }

    // Handle file upload
    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('covers', 'public');
        $validated['cover_image'] = $path;
    }

    // Create book
    $book = Book::create($validated);

    // Sync categories if any
    if (isset($validated['categories'])) {
        $book->categories()->sync($validated['categories']);
    }

    return redirect()->route('books.show', $book)
        ->with('success', 'Book created successfully!');
}

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book->update($validated);
        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}