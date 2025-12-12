<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'isbn',
        'author',
        'price',
        'stock_quantity',
        'cover_image',
        'published_date'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    protected static function boot()
{
    parent::boot();
    static::creating(function ($book) {
        if (empty($book->slug)) {
            $slug = Str::slug($book->title);
            $count = Book::where('slug', 'LIKE', "{$slug}%")->count();
            $book->slug = $count ? "{$slug}-{$count}" : $slug;
        }
    });
    static::updating(function ($book) {
        if ($book->isDirty('title')) {
            $slug = Str::slug($book->title);
            $count = Book::where('id', '!=', $book->id)
                ->where('slug', 'LIKE', "{$slug}%")
                ->count();
            $book->slug = $count ? "{$slug}-{$count}" : $slug;
        }
    });
}
}
