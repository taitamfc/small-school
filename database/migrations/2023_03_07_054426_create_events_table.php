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
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('recurrence')->nullable();
            $table->unsignedInteger('event_id')->nullable(); 
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->unsignedBigInteger('student_id')->nullable(); 
            $table->foreign('student_id')->references('id')->on('students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
