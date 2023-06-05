<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('meal_type');
            $table->integer('n_servings');
            $table->integer('prep_time');
            $table->integer('cook_time');
            $table->text('description');
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->string('cuisine');
            $table->json('instructions');
            $table->json('tips');
            $table->enum('status', ['published', 'draft']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
