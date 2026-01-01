@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Book
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Books</h6>
                            <h2 class="mb-0">{{ $stats['total_books'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-book text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('books.index') }}" class="text-decoration-none small">
                            View all books <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Categories</h6>
                            <h2 class="mb-0">{{ $stats['total_categories'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-tags text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none small">
                            Manage categories <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Low Stock</h6>
                            <h2 class="mb-0">{{ $stats['low_stock_count'] ?? 0 }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('books.index') }}?stock=low" class="text-decoration-none small">
                            View low stock <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Value</h6>
                            <h2 class="mb-0">${{ number_format($stats['total_value'] ?? 0, 2) }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-dollar-sign text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-decoration-none small">
                            View reports <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Books -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Recent Books</h5>
                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($recentBooks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBooks as $book)
                                        <tr>
                                            <td>
                                                @if($book->cover_image)
                                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="img-thumbnail" style="width: 40px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 60px;">
                                                        <i class="fas fa-book text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($book->title, 30) }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>${{ number_format($book->price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $book->stock_quantity < 5 ? 'bg-warning' : 'bg-success' }}">
                                                    {{ $book->stock_quantity }} in stock
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('books.show', $book->slug) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="fas fa-book-open fa-3x"></i>
                            </div>
                            <h5>No books found</h5>
                            <p class="text-muted">Add your first book to get started</p>
                            <a href="{{ route('books.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-2"></i>Add New Book
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="col-12 col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('books.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="fas fa-plus text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Add New Book</h6>
                            <small class="text-muted">Add a new book to your inventory</small>
                        </div>
                    </a>
                    <a href="{{ route('books.import') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                            <i class="fas fa-file-import text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Import Books</h6>
                            <small class="text-muted">Import books from Excel/CSV</small>
                        </div>
                    </a>
                    <a href="{{ route('books.export') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                            <i class="fas fa-file-export text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Export Books</h6>
                            <small class="text-muted">Export books to Excel/CSV</small>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                            <i class="fas fa-chart-bar text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">View Reports</h6>
                            <small class="text-muted">View sales and inventory reports</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentActivities->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-light p-2 rounded-circle">
                                                <i class="fas {{ $activity->icon }} text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">{{ $activity->title }}</h6>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 small text-muted">{{ $activity->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="fas fa-history fa-3x"></i>
                            </div>
                            <h6>No recent activity</h6>
                            <p class="small text-muted">Your activities will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
