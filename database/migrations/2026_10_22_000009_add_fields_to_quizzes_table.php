<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->text('question')->nullable();
            $table->json('options')->nullable();
            $table->string('correct_answer')->nullable();
            $table->string('image')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['question', 'options', 'correct_answer', 'image']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['image']);
        });
    }
};
