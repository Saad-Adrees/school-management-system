<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            // Assuming you have a 'students' table with an 'id'
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->integer('marks_obtained');
            $table->integer('total_marks')->default(100);
            $table->string('grade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};