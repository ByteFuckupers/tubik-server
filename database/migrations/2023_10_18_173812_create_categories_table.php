<?php

use App\Models\Categories;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('slug'); // This is thу text for the URL
            $table->boolean('active')->default(true);
            $table->foreignIdFor(Categories::class, 'category_id')->constrained()->nullOnDelete();
            $table->text('description');
            $table->string('image');
            $table->string('icon');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
