<?php

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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->index()->references('id')->on('students');
            $table->foreignId('day_id')->nullable()->index()->references('id')->on('days');
            $table->foreignId('time_lesson_id')->nullable()->index()->references('id')->on('time_lessons');
            $table->foreignId('cabinet_id')->nullable()->index()->references('id')->on('cabinets');
            $table->foreignId('teacher_id')->nullable()->index()->references('id')->on('teachers');
            $table->foreignId('lab_id')->nullable()->index()->references('id')->on('labs');
            $table->foreignId('discipline_id')->nullable()->index()->references('id')->on('disciplins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
