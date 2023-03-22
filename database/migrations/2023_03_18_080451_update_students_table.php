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
        Schema::table('students', function (Blueprint $table) {
            $table->text('course_content')->nullable();
            $table->string('user_name')->nullable();
            $table->unsignedBigInteger('course_id')->nullable(); 
            $table->unsignedBigInteger('room_id')->nullable(); 
            $table->double('fee')->nullable(); 
            $table->double('debt')->nullable(); 
            $table->unsignedBigInteger('saler_id')->nullable(); 
            $table->unsignedBigInteger('student_care_id')->nullable(); 
            $table->unsignedBigInteger('teacher_id')->nullable(); 
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('exercise_date')->nullable();
            $table->text('link_folder')->nullable();
            $table->text('link_calendar')->nullable();
            $table->text('note')->nullable();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
