<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get book statistics
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'low_stock_count' => Book::where('stock_quantity', '<', 5)->count(),
            'total_value' => Book::sum(DB::raw('price * stock_quantity')),
        ];

        // Get recent books
        $recentBooks = Book::with('categories')
            ->latest()
            ->take(5)
            ->get();

        // Mock recent activities (you can replace this with a real activity log)
        $recentActivities = collect([
            (object)[
                'icon' => 'fa-book',
                'title' => 'New Book Added',
                'description' => 'Added "The Great Gatsby" to the inventory',
                'created_at' => now()->subMinutes(15),
            ],
            (object)[
                'icon' => 'fa-user',
                'title' => 'User Login',
                'description' => 'You logged in to the system',
                'created_at' => now()->subHours(1),
            ],
            (object)[
                'icon' => 'fa-tags',
                'title' => 'Category Updated',
                'description' => 'Updated "Fiction" category',
                'created_at' => now()->subHours(3),
            ],
        ]);

        return view('home', compact('stats', 'recentBooks', 'recentActivities'));
    }
}