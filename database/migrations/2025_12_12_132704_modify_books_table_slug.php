<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // For SQLite, we'll recreate the table
        if (DB::getDriverName() === 'sqlite') {
            // Create new table with nullable slug
            Schema::create('books_new', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->string('isbn')->nullable();
                $table->string('author');
                $table->decimal('price', 8, 2);
                $table->integer('stock_quantity')->default(0);
                $table->string('cover_image')->nullable();
                $table->date('published_date')->nullable();
                $table->timestamps();
            });

            // Copy existing data
            DB::statement('
                INSERT INTO books_new (id, title, slug, description, isbn, author, 
                price, stock_quantity, cover_image, published_date, created_at, updated_at)
                SELECT id, title, slug, description, isbn, author, 
                price, stock_quantity, cover_image, published_date, created_at, updated_at 
                FROM books
            ');

            // Replace the old table
            Schema::drop('books');
            Schema::rename('books_new', 'books');
        } else {
            // For other databases
            Schema::table('books', function (Blueprint $table) {
                $table->string('slug')->nullable()->change();
            });
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            // Create old table structure
            Schema::create('books_old', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->text('description')->nullable();
                $table->string('isbn')->nullable();
                $table->string('author');
                $table->decimal('price', 8, 2);
                $table->integer('stock_quantity')->default(0);
                $table->string('cover_image')->nullable();
                $table->date('published_date')->nullable();
                $table->timestamps();
            });

            // Copy data back
            DB::statement('
                INSERT INTO books_old (id, title, slug, description, isbn, author, 
                price, stock_quantity, cover_image, published_date, created_at, updated_at)
                SELECT id, title, COALESCE(slug, "") as slug, description, isbn, author, 
                price, stock_quantity, cover_image, published_date, created_at, updated_at 
                FROM books
            ');

            // Replace the table
            Schema::drop('books');
            Schema::rename('books_old', 'books');
        } else {
            Schema::table('books', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->change();
            });
        }
    }
};

