<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BooksTableSeeder extends Seeder
{
   // database/seeders/BooksTableSeeder.php
public function run()
{
    // Create categories
    $categories = [
        ['name' => 'Fiction', 'slug' => 'fiction'],
        ['name' => 'Non-Fiction', 'slug' => 'non-fiction'],
        ['name' => 'Science Fiction', 'slug' => 'science-fiction', 'parent_id' => 1],
        ['name' => 'Fantasy', 'slug' => 'fantasy', 'parent_id' => 1],
    ];
    foreach ($categories as $category) {
        Category::create($category);
    }
    // Create sample books
    $books = [
        [
            'title' => 'Sample Book 1',
            'slug' => 'sample-book-1',
            'description' => 'This is a sample book description.',
            'isbn' => '1234567890',
            'author' => 'John Doe',
            'price' => 29.99,
            'stock_quantity' => 50,
            'categories' => [1, 3] // Fiction, Science Fiction
        ],
        // Add more sample books as needed
    ];
    foreach ($books as $bookData) {
        $categories = $bookData['categories'];
        unset($bookData['categories']);
        
        $book = Book::create($bookData);
        $book->categories()->attach($categories);
    }
}
}
