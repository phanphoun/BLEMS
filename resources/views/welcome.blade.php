<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Book Management System</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/sass/app.scss'])
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .category-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="fas fa-book me-2"></i>BookMarks
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.index') }}">All Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Authors</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-primary ms-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('books.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Book
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-5">
        <div class="container py-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Discover Your Next Favorite Book</h1>
                    <p class="lead mb-5">
                        Explore our vast collection of books across various genres. Find your next great read today!
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('books.index') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-book me-2"></i>Browse Books
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-user-plus me-2"></i>Join Now
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Featured Books -->
    <!-- Featured Books -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Featured</span>
                <h2 class="display-5 fw-bold mb-3">Popular Books</h2>
                <p class="lead text-muted">Check out our most popular books this week.</p>
            </div>

            <div class="row g-4">
                @forelse($featuredBooks as $book)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card h-100 book-card shadow-sm">
                            <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none">
                                @if($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 300px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <div class="text-center p-3">
                                            <i class="fas fa-book fa-4x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">No cover image</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-dark">{{ Str::limit($book->title, 40) }}</h5>
                                    <p class="card-text text-muted">By {{ $book->author }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 text-primary">${{ number_format($book->price, 2) }}</span>
                                        @if($book->categories->count() > 0)
                                            <div>
                                                @foreach($book->categories->take(2) as $category)
                                                    <span class="badge bg-primary bg-opacity-10 text-primary category-badge">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                                @if($book->categories->count() > 2)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary category-badge">
                                                        +{{ $book->categories->count() - 2 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="display-1 text-muted mb-4">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="h2">No books available yet</h3>
                        <p class="lead text-muted">Check back later for new additions to our collection.</p>
                        @auth
                            <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg mt-3">
                                <i class="fas fa-plus me-2"></i>Add Your First Book
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($featuredBooks->isNotEmpty())
                <div class="text-center mt-5">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">
                        View All Books
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

        <!-- Categories Section -->
    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Browse</span>
                <h2 class="display-5 fw-bold mb-3">Popular Categories</h2>
                <p class="lead text-muted">Explore books by category</p>
            </div>

            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                            <div class="card h-100 text-center border-0 shadow-sm hover-shadow transition-all">
                                <div class="card-body p-4">
                                    <div class="icon-lg bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <h5 class="card-title mb-1">{{ $category->name }}</h5>
                                    <p class="small text-muted mb-0">{{ $category->books_count ?? 0 }} books</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-primary text-white py-5">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-4">Ready to dive in?</h2>
                    <p class="lead mb-5">
                        Join thousands of readers who have already discovered their next favorite book with us.
                    </p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-2">
                            <i class="fas fa-user-plus me-2"></i>Sign up for free
                        </a>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-book me-2"></i>Browse Books
                        </a>
                    @else
                        <a href="{{ route('books.create') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-plus-circle me-2"></i>Add a Book
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="h6 mb-3">
                        <i class="fas fa-book me-2"></i>BookMarks
                    </h5>
                    <p class="small text-muted">
                        Your one-stop destination for discovering and sharing great books across all genres.
                    </p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fs-6 fw-bold mb-3">Explore</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('books.index') }}" class="text-decoration-none text-muted small">All Books</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Categories</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Authors</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">New Releases</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fs-6 fw-bold mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Careers</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Contact</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fs-6 fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Terms of Service</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted small">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fs-6 fw-bold mb-3">Connect</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0">&copy; {{ date('Y') }} BookMarks. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="small text-muted mb-0">Made with <i class="fas fa-heart text-danger"></i> by BookMarks Team</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</body>
</html>