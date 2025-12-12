<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->string('isbn')->unique();
        $table->string('author');
        $table->decimal('price', 10, 2);
        $table->integer('stock_quantity')->default(0);
        $table->string('cover_image')->nullable();
        $table->date('published_date')->nullable();
        $table->timestamps();
    });
}
};
